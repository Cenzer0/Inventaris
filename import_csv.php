<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Unit;
use App\Models\Item;
use App\Models\InventoryTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Month map
$monthMap = [
    'Januari 2026' => '2026-01',
    'Februari 2026' => '2026-02',
    'Maret 2026' => '2026-03',
    'April 2026' => '2026-04',
    'Mei 2026' => '2026-05',
];

$file = fopen(__DIR__ . '/data_persediaan_jan_sd_mei2026.csv', 'r');
$header = fgetcsv($file);

DB::beginTransaction();
try {
    $admin = User::where('role', 'admin_gudang')->first();
    if (!$admin) {
        $admin = User::first();
    }
    $adminId = $admin ? $admin->id : 1;

    // Track items that we've set initial balance for
    $initialBalanceSet = [];

    while ($row = fgetcsv($file)) {
        if (count($row) < 17) continue;

        $data = array_combine($header, array_pad($row, count($header), ''));
        
        // Find or create Category
        $catCode = '01'; // dummy, better to increment based on existing
        $category = Category::firstOrCreate(
            ['name' => $data['kategori']],
            ['code' => substr(md5($data['kategori']), 0, 5)] 
        );

        // Find or create Unit
        $unitName = strtolower(trim($data['satuan']));
        if (empty($unitName)) $unitName = 'pcs';
        $unit = Unit::firstOrCreate(['name' => $unitName]);

        // Determine price
        $price = (float) $data['pengadaan_harga_satuan'];
        if ($price == 0) {
            $price = (float) $data['sisa_lalu_harga_satuan'];
        }
        if ($price == 0) {
            $price = (float) $data['pemakaian_harga_satuan'];
        }

        // Find or create Item
        $item = Item::firstOrCreate(
            ['name' => trim($data['nama_barang'])],
            [
                'category_id' => $category->id,
                'unit_id' => $unit->id,
                'simda_code' => '1.1.7.01.' . rand(10, 99),
                'unit_price' => $price,
                'stock' => 0, // will be updated later
                'description' => $data['keterangan'] ?? ''
            ]
        );

        // Update item price and category if it was already created
        $item->unit_price = $price;
        $item->category_id = $category->id;
        $item->unit_id = $unit->id;
        $item->save();

        $monthStr = trim($data['bulan']);
        if (!isset($monthMap[$monthStr])) continue;
        $ym = $monthMap[$monthStr];

        // 1. Initial Balance (Sisa Lalu)
        // We only insert sisa_lalu once per item when it first appears and has > 0 sisa_lalu
        $sisaLaluVol = (int) $data['sisa_lalu_volume'];
        if ($sisaLaluVol > 0 && !isset($initialBalanceSet[$item->id])) {
            $initialDate = Carbon::parse($ym . '-01')->subDay()->format('Y-m-d');
            InventoryTransaction::create([
                'item_id' => $item->id,
                'user_id' => $adminId,
                'transaction_type' => 'adjustment', // 'procurement' or 'adjustment'
                'quantity' => $sisaLaluVol,
                'unit_price' => (float) $data['sisa_lalu_harga_satuan'],
                'transaction_date' => $initialDate,
                'notes' => 'Initial balance from import'
            ]);
        }
        $initialBalanceSet[$item->id] = true;

        // 2. Pengadaan
        $pengadaanVol = (int) $data['pengadaan_volume'];
        if ($pengadaanVol > 0) {
            InventoryTransaction::create([
                'item_id' => $item->id,
                'user_id' => $adminId,
                'transaction_type' => 'procurement',
                'quantity' => $pengadaanVol,
                'unit_price' => (float) $data['pengadaan_harga_satuan'],
                'transaction_date' => $ym . '-10', // arbitrary day in the month
                'notes' => 'Pengadaan ' . $monthStr
            ]);
        }

        // 3. Pemakaian
        $pemakaianVol = (int) $data['pemakaian_volume'];
        if ($pemakaianVol > 0) {
            InventoryTransaction::create([
                'item_id' => $item->id,
                'user_id' => $adminId,
                'transaction_type' => 'usage',
                'quantity' => $pemakaianVol,
                'unit_price' => (float) $data['pemakaian_harga_satuan'],
                'transaction_date' => $ym . '-20', // arbitrary day in the month
                'notes' => 'Pemakaian ' . $monthStr
            ]);
        }
    }
    
    // Recalculate all stock for items
    $items = Item::all();
    foreach ($items as $it) {
        $in = InventoryTransaction::where('item_id', $it->id)
                ->whereIn('transaction_type', ['procurement', 'adjustment'])->sum('quantity');
        $out = InventoryTransaction::where('item_id', $it->id)
                ->where('transaction_type', 'usage')->sum('quantity');
        $it->stock = $in - $out;
        $it->save();
    }

    DB::commit();
    echo "Import successful!\n";

} catch (\Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}

fclose($file);

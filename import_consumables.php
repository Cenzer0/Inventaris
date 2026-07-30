<?php

use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

$file = fopen('consumables_may2026.csv', 'r');
$header = fgetcsv($file); // Skip header

DB::beginTransaction();
try {
    while (($row = fgetcsv($file)) !== false) {
        if (count($row) < 16) continue;
        
        $kategori = trim($row[0]);
        $nama_barang = trim($row[1]);
        $satuan = trim($row[2]);
        $sisa_lalu_volume = (float)$row[3];
        $sisa_lalu_harga_satuan = (float)$row[4];
        $pengadaan_volume = (float)$row[6];
        $pengadaan_harga_satuan = (float)$row[7];
        $pemakaian_volume = (float)$row[11];
        
        // 1. Get or Create Category
        // map names to existing codes if possible
        $code = '1.1.5.1'; // default ATK
        if (str_contains(strtolower($kategori), 'pos')) {
            $code = '1.1.5.4';
        } elseif (str_contains(strtolower($kategori), 'cetakan')) {
            $code = '1.1.5.7.4';
        }
        
        $category = Category::where('code', $code)->first();
        if (!$category) {
            $category = Category::create(['name' => $kategori, 'code' => $code, 'description' => $kategori]);
        } else {
            // update name to match the report's category
            if ($category->name != $kategori) {
                $category->name = $kategori;
                $category->save();
            }
        }
        
        // 2. Get or Create Unit
        $unit = Unit::firstOrCreate(['name' => strtolower($satuan)], ['description' => ucfirst($satuan)]);
        
        // 3. Get or Create Item
        $item = Item::where('name', $nama_barang)->first();
        if (!$item) {
            $item = Item::create([
                'name' => $nama_barang,
                'simda_code' => $category->code . '.' . rand(100, 999),
                'description' => 'Persediaan ' . $nama_barang,
                'category_id' => $category->id,
                'unit_id' => $unit->id,
                'item_type' => 'Umum',
                'stock' => 0,
                'unit_price' => $pengadaan_harga_satuan > 0 ? $pengadaan_harga_satuan : $sisa_lalu_harga_satuan
            ]);
        }
        
        // Ensure category matches
        if ($item->category_id != $category->id) {
            $item->category_id = $category->id;
            $item->save();
        }
        
        // 4. Create Transactions
        $userId = 1; // Admin
        
        // Initial Balance (Sisa Lalu)
        if ($sisa_lalu_volume > 0) {
            InventoryTransaction::create([
                'item_id' => $item->id,
                'user_id' => $userId,
                'transaction_type' => 'procurement',
                'quantity' => $sisa_lalu_volume,
                'unit_price' => $sisa_lalu_harga_satuan,
                'transaction_date' => '2026-04-30 10:00:00', // Previous month
                'notes' => 'Saldo Awal (Sisa Lalu)'
            ]);
            $item->stock += $sisa_lalu_volume;
        }
        
        // Incoming (Pengadaan)
        if ($pengadaan_volume > 0) {
            InventoryTransaction::create([
                'item_id' => $item->id,
                'user_id' => $userId,
                'transaction_type' => 'procurement',
                'quantity' => $pengadaan_volume,
                'unit_price' => $pengadaan_harga_satuan,
                'transaction_date' => '2026-05-15 10:00:00',
                'notes' => 'Pengadaan Mei 2026'
            ]);
            $item->stock += $pengadaan_volume;
        }
        
        // Outgoing (Pemakaian)
        if ($pemakaian_volume > 0) {
            InventoryTransaction::create([
                'item_id' => $item->id,
                'user_id' => $userId,
                'transaction_type' => 'usage',
                'quantity' => $pemakaian_volume,
                'unit_price' => $pengadaan_harga_satuan > 0 ? $pengadaan_harga_satuan : $sisa_lalu_harga_satuan,
                'transaction_date' => '2026-05-20 14:00:00',
                'notes' => 'Pemakaian Mei 2026'
            ]);
            $item->stock -= $pemakaian_volume;
        }
        
        $item->save();
    }
    DB::commit();
    echo "Import success.\n";
} catch (\Exception $e) {
    DB::rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
fclose($file);

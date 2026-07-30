<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Unit;
use App\Models\Item;
use App\Models\RekapPersediaan;

$file = fopen(__DIR__ . '/data_persediaan_jan_sd_mei2026.csv', 'r');
$header = fgetcsv($file);

try {
    RekapPersediaan::truncate();

    while ($row = fgetcsv($file)) {
        if (count($row) < 17) continue;

        $data = array_combine($header, array_pad($row, count($header), ''));
        
        $monthStr = trim($data['bulan']);
        $itemName = trim($data['nama_barang']);

        $item = Item::where('name', $itemName)->first();
        if (!$item) {
            echo "Item not found: $itemName\n";
            continue;
        }

        RekapPersediaan::updateOrCreate(
            [
                'bulan' => $monthStr,
                'item_id' => $item->id
            ],
            [
                'sisa_lalu_volume' => (int) $data['sisa_lalu_volume'],
                'sisa_lalu_harga_satuan' => (float) $data['sisa_lalu_harga_satuan'],
                'sisa_lalu_total' => (float) $data['sisa_lalu_total'],
                
                'pengadaan_volume' => (int) $data['pengadaan_volume'],
                'pengadaan_harga_satuan' => (float) $data['pengadaan_harga_satuan'],
                'pengadaan_total' => (float) $data['pengadaan_total'],
                
                'jumlah_volume' => (int) $data['jumlah_volume'],
                'jumlah_harga' => (float) $data['jumlah_harga'],
                
                'pemakaian_volume' => (int) $data['pemakaian_volume'],
                'pemakaian_harga_satuan' => (float) $data['pemakaian_harga_satuan'],
                'pemakaian_total' => (float) $data['pemakaian_total'],
                
                'sisa_volume' => (int) $data['sisa_volume'],
                'sisa_harga' => (float) $data['sisa_harga'],
                
                'keterangan' => $data['keterangan'] ?? ''
            ]
        );
    }
    
    echo "Import to rekap_persediaans successful!\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}

fclose($file);

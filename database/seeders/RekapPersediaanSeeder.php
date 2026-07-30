<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\RekapPersediaan;
use App\Models\Item;

class RekapPersediaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data_persediaan_mei2026.json'));
        $data = json_decode($json, true);

        foreach ($data as $row) {
            // Find item by name (to get item_id)
            $item = Item::where('name', $row['nama_barang'])->first();
            if (!$item) {
                // If item not found, just skip or we could create it. The DB should already have these from previous seeders.
                continue;
            }

            RekapPersediaan::updateOrCreate(
                [
                    'bulan' => 'Mei 2026',
                    'item_id' => $item->id,
                ],
                [
                    'sisa_lalu_volume' => $row['sisa_lalu_volume'],
                    'sisa_lalu_harga_satuan' => $row['sisa_lalu_harga_satuan'],
                    'sisa_lalu_total' => $row['sisa_lalu_total'],
                    'pengadaan_volume' => $row['pengadaan_volume'],
                    'pengadaan_harga_satuan' => $row['pengadaan_harga_satuan'],
                    'pengadaan_total' => $row['pengadaan_total'],
                    'jumlah_volume' => $row['jumlah_volume'],
                    'jumlah_harga' => $row['jumlah_harga'],
                    'pemakaian_volume' => $row['pemakaian_volume'],
                    'pemakaian_harga_satuan' => $row['pemakaian_harga_satuan'],
                    'pemakaian_total' => $row['pemakaian_total'],
                    'sisa_volume' => $row['sisa_volume'],
                    'sisa_harga' => $row['sisa_harga'],
                    'keterangan' => $row['keterangan'] ?? null,
                ]
            );
        }
    }
}

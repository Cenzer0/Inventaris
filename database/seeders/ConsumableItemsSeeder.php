<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;

class ConsumableItemsSeeder extends Seeder
{
    public function run()
    {
        $rawData = [
            ['Persediaan Alat Tulis Kantor','Amplop sedang','dus',0.0,20400.0,0.0,0.0,20400.0,0.0,0.0,0.0,0.0,20400.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Ballpoint-kerja','buah',0.0,4000.0,0.0,24.0,4000.0,96000.0,24.0,96000.0,20.0,4000.0,80000.0,4.0,16000.0,'0'],
            ['Persediaan Alat Tulis Kantor','Ballpoint - boxy/baliner','buah',0.0,18400.0,0.0,0.0,18400.0,0.0,0.0,0.0,0.0,18400.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Binder  Clip  155','dus',0.0,950.0,0.0,0.0,950.0,0.0,0.0,0.0,0.0,950.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Binder  Clip 200','Buah',0.0,1600.0,0.0,0.0,1600.0,0.0,0.0,0.0,0.0,1600.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Binder  Clip 260','Dus',0.0,18600.0,0.0,0.0,18600.0,0.0,0.0,0.0,0.0,18600.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Buku Ekspedisi','buku',0.0,14500.0,0.0,0.0,14500.0,0.0,0.0,0.0,0.0,14500.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Buku Folio Garis isi 100 lembar','buah',0.0,22200.0,0.0,0.0,22200.0,0.0,0.0,0.0,0.0,22200.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','file box - plastik warna','buah',0.0,31900.0,0.0,0.0,31900.0,0.0,0.0,0.0,0.0,31900.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Isi Hechtneices no.10','dus',0.0,4200.0,0.0,0.0,4200.0,0.0,0.0,0.0,0.0,4200.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Kertas HVS - Folio  : 70 gram','rim',0.0,69100.0,0.0,15.0,69100.0,1036500.0,15.0,1036500.0,13.0,69100.0,898300.0,2.0,138200.0,'0'],
            ['Persediaan Alat Tulis Kantor','Kertas HVS - Folio  : 80 gram','rim',0.0,70200.0,0.0,20.0,70200.0,1404000.0,20.0,1404000.0,18.0,70200.0,1263600.0,2.0,140400.0,'0'],
            ['Persediaan Alat Tulis Kantor','Kertas HVS Ukuran A4  : 70 gram','rim',0.0,59300.0,0.0,9.0,59300.0,533700.0,9.0,533700.0,9.0,59300.0,533700.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Klip Jumbo','dus',0.0,8300.0,0.0,0.0,8300.0,0.0,0.0,0.0,0.0,8300.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Map Dokumen Sleting','buah',0.0,23800.0,0.0,15.0,23800.0,357000.0,15.0,357000.0,7.0,23800.0,166600.0,8.0,190400.0,'0'],
            ['Persediaan Alat Tulis Kantor','Ordner Folio','buah',0.0,41300.0,0.0,0.0,41300.0,0.0,0.0,0.0,0.0,41300.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Pensil - Hitam 2B','buah',0.0,6200.0,0.0,0.0,6200.0,0.0,0.0,0.0,0.0,5000.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Post it','pak',0.0,64000.0,0.0,10.0,64000.0,640000.0,10.0,640000.0,0.0,64000.0,0.0,0.0,640000.0,'0'],
            ['Persediaan Alat Tulis Kantor','Snelhectter - Plastik','buah',0.0,4200.0,0.0,0.0,4200.0,0.0,0.0,0.0,0.0,4200.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Stabilo Kecil','Buah',0.0,10400.0,0.0,5.0,10400.0,52000.0,5.0,52000.0,5.0,10400.0,52000.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Tinta Stempel','botol',0.0,18200.0,0.0,0.0,18200.0,0.0,0.0,0.0,0.0,18200.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Type Ex Ballpoint','buah',0.0,39400.0,0.0,5.0,39400.0,197000.0,5.0,197000.0,4.0,39400.0,157600.0,1.0,39400.0,'0'],
            ['Persediaan Alat Tulis Kantor','Plak ban','Roll',0.0,20300.0,0.0,2.0,20300.0,40600.0,2.0,40600.0,2.0,20300.0,40600.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Setip Biasa','Buah',0.0,14500.0,0.0,0.0,14500.0,0.0,0.0,0.0,0.0,14500.0,0.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Spidol Besar Permanen','Buah',0.0,10000.0,0.0,3.0,10000.0,30000.0,3.0,30000.0,3.0,10000.0,30000.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Tinta Printer Warna','buah',0.0,65700.0,0.0,3.0,65700.0,197100.0,3.0,197100.0,2.0,65700.0,131400.0,1.0,65700.0,'0'],
            ['Persediaan Alat Tulis Kantor','Tinta Printer Hitam','buah',0.0,58600.0,0.0,3.0,58600.0,175800.0,3.0,175800.0,3.0,58600.0,175800.0,0.0,0.0,'0'],
            ['Persediaan Alat Tulis Kantor','Usb/Flash Disk - 32GB','buah',0.0,55000.0,0.0,3.0,55000.0,165000.0,3.0,165000.0,0.0,55000.0,0.0,3.0,165000.0,'0'],
            ['Persediaan Benda Pos','Materai 10000','buah',0.0,10000.0,0.0,0.0,10000.0,0.0,0.0,0.0,0.0,10000.0,0.0,0.0,0.0,'0'],
            ['Persediaan Barang Cetakan Lainnya','Blangko SPPD NCR 4 Rangkap','buku',0.0,51.6,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,'0'],
            ['Persediaan Barang Cetakan Lainnya','Blangko Lambang Garuda(Emas)','Set',50.0,2900.0,0.0,0.0,2900.0,0.0,50.0,0.0,0.0,2900.0,0.0,50.0,145000.0,'0'],
            ['Persediaan Barang Cetakan Lainnya','Cetak Buku','buku',0.0,19600.0,0.0,0.0,19600.0,0.0,0.0,0.0,0.0,19600.0,0.0,0.0,0.0,'0'],
            ['Persediaan Barang Cetakan Lainnya','Stopmap','buah',30.0,8300.0,0.0,0.0,8300.0,0.0,30.0,0.0,0.0,8300.0,0.0,30.0,249000.0,'0']
        ];

        foreach ($rawData as $index => $row) {
            $kategori = $row[0];
            $nama_barang = $row[1];
            $satuan = strtolower($row[2]);
            $harga_satuan = max($row[4], $row[7], $row[12]); 
            $sisa_volume = $row[14]; 
            
            // Map kategori to category_id
            $categoryId = 1; // Default: Barang Habis Pakai
            if ($kategori === 'Persediaan Benda Pos') {
                $categoryId = 5; // Persediaan Benda Pos
            } elseif ($kategori === 'Persediaan Barang Cetakan Lainnya') {
                $categoryId = 6; // Persediaan Barang Cetakan Lainnya
            }

            // Find or create unit
            $unit = Unit::firstOrCreate(
                ['name' => ucfirst($satuan)],
                ['description' => 'Satuan ' . ucfirst($satuan)]
            );

            // Generate SIMDA code
            $simdaCode = 'BHP-MAY26-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);

            Item::create([
                'simda_code' => $simdaCode,
                'name' => $nama_barang,
                'category_id' => $categoryId,
                'unit_id' => $unit->id,
                'unit_price' => $harga_satuan,
                'stock' => $sisa_volume,
                'item_type' => 'Umum',
                'asset_category' => $kategori,
                'description' => 'Data Persediaan Bulan Mei 2026',
            ]);
        }
    }
}

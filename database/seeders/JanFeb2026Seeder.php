<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RekapPersediaan;
use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;

class JanFeb2026Seeder extends Seeder
{
    public function run()
    {
        $csv = <<<EOF
bulan,kategori,nama_barang,satuan,sisa_lalu_volume,sisa_lalu_harga_satuan,sisa_lalu_total,pengadaan_volume,pengadaan_harga_satuan,pengadaan_total,jumlah_volume,jumlah_harga,pemakaian_volume,pemakaian_harga_satuan,pemakaian_total,sisa_volume,sisa_harga,keterangan
Januari 2026,Persediaan Alat Tulis Kantor,Amplop sedang,dus,0,20400,0,0,20400,0,0,0,0,20400,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Ballpoint-kerja,buah,19,4000,76000,0,4000,0,19,76000,9,4000,36000,10,40000,
Januari 2026,Persediaan Alat Tulis Kantor,Ballpoint - boxy/baliner,buah,3,18400,55200,0,18400,0,3,55200,3,18400,55200,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Binder  Clip  155,dus,80,950,76000,0,950,0,80,76000,80,950,76000,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Binder  Clip 200,Buah,60,1600,96000,0,1600,0,60,96000,10,1600,16000,50,80000,
Januari 2026,Persediaan Alat Tulis Kantor,Buku Ekspedisi,buku,0,14500,0,0,14500,0,0,0,0,14500,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,file box - plastik warna,buah,3,31900,95700,0,31900,0,3,95700,3,31900,95700,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Isi Hechtneices no.10,dus,20,4200,84000,0,4200,0,20,84000,10,4200,42000,0,42000,
Januari 2026,Persediaan Alat Tulis Kantor,Kertas HVS - Folio  : 70 gram,rim,5,69100,345500,0,69100,0,5,345500,5,69100,345500,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Kertas HVS - Folio  : 80 gram,rim,0,70200,0,0,70200,0,0,0,0,70200,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Kertas HVS Ukuran A4  : 70 gram,rim,0,59300,0,0,59300,0,0,0,0,59300,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Klip Jumbo,dus,0,8300,0,0,8300,0,0,0,0,8300,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Map Dokumen Sleting,buah,0,23800,0,0,23800,0,0,0,0,23800,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Ordner Folio,buah,2,41300,82600,0,41300,0,2,82600,2,41300,82600,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Pensil - Hitam 2B,buah,0,5000,0,0,6200,0,0,0,0,5000,60800,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Post it,pak,1,64000,64000,0,64000,0,1,64000,1,64000,64000,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Snelhectter - Plastik,buah,2,4200,8400,0,4200,0,2,8400,2,4200,8400,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Stabilo Kecil,Buah,0,10400,0,0,10400,0,0,0,0,10400,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Tinta Stempel,botol,0,18200,0,0,18200,0,0,0,0,18200,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Type Ex Ballpoint,buah,1,39400,39400,0,39400,0,1,39400,1,39400,39400,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Plak ban,Roll,7,20300,142100,0,20300,0,7,142100,7,20300,142100,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Setip Biasa,Buah,5,14500,72500,0,14500,0,5,72500,5,14500,72500,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Spidol Besar Permanen,Buah,0,10000,0,0,10000,0,0,0,0,10000,0,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Tinta Printer Warna,buah,2,65700,131400,0,65700,0,2,131400,2,65700,131400,0,0,
Januari 2026,Persediaan Alat Tulis Kantor,Tinta Printer Hitam,buah,1,58600,58600,0,58600,0,1,58600,0,58600,58600,1,58600,
Januari 2026,Persediaan Alat Tulis Kantor,Usb/Flash Disk - 32GB,buah,0,55000,0,0,55000,0,0,0,0,55000,0,0,0,
Januari 2026,Persediaan Benda Pos,Materai 10000,buah,0,10400,0,0,10400,0,0,0,0,10400,0,0,0,
Januari 2026,Persediaan Barang Cetakan Lainnya,Stopmap Lambang Lima Warna,buah,40,8300,332000,0,0,0,40,332000,10,7000,70000,30,262000,
Januari 2026,Persediaan Barang Cetakan Lainnya,Blangko SPPD NCR 4 Rangkap,buku,0,0,0,0,0,0,0,0,0,0,0,0,0,
Januari 2026,Persediaan Barang Cetakan Lainnya,Blangko Lambang Garuda,Set,430,2900,1247000,0,0,0,430,1247000,50,2800,140000,380,1107000,
Januari 2026,Persediaan Barang Cetakan Lainnya,Blanko cetakan 1 folio kertas Doorslag warna 2 Muka,buku,0,0,0,0,0,0,0,0,0,0,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Amplop sedang,dus,0,20400,0,0,20400,0,0,0,0,20400,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Ballpoint-kerja,buah,10,4000,40000,0,4000,0,10,40000,10,4000,40000,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Ballpoint - boxy/baliner,buah,0,18400,0,0,18400,0,0,0,0,18400,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Binder  Clip  155,dus,0,950,0,0,950,0,0,0,0,950,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Binder  Clip 200,Buah,50,1600,80000,0,1600,0,50,80000,10,1600,16000,40,64000,
Februari 2026,Persediaan Alat Tulis Kantor,Buku Ekspedisi,buku,0,14500,0,0,14500,0,0,0,0,14500,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,file box - plastik warna,buah,0,31900,0,0,31900,0,0,0,0,31900,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Isi Hechtneices no.10,dus,0,4200,42000,0,4200,0,0,0,0,4200,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Kertas HVS - Folio  : 70 gram,rim,0,69100,0,0,69100,0,0,0,0,69100,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Kertas HVS - Folio  : 80 gram,rim,0,70200,0,0,70200,0,0,0,0,70200,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Kertas HVS Ukuran A4  : 70 gram,rim,0,59300,0,0,59300,0,0,0,0,59300,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Klip Jumbo,dus,0,8300,0,0,8300,0,0,0,0,8300,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Map Dokumen Sleting,buah,0,23800,0,0,23800,0,0,0,0,23800,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Ordner Folio,buah,0,41300,0,0,41300,0,0,0,0,41300,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Pensil - Hitam 2B,buah,0,5000,0,0,6200,0,0,0,0,5000,60800,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Post it,pak,0,64000,0,0,64000,0,0,0,0,64000,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Snelhectter - Plastik,buah,0,4200,0,0,4200,0,0,0,0,4200,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Stabilo Kecil,Buah,0,10400,0,0,10400,0,0,0,0,10400,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Tinta Stempel,botol,0,18200,0,0,18200,0,0,0,0,18200,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Type Ex Ballpoint,buah,0,39400,0,0,39400,0,0,0,0,39400,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Plak ban,Roll,0,20300,0,0,20300,0,7,0,7,20300,142100,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Setip Biasa,Buah,0,14500,0,0,14500,0,0,0,0,14500,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Spidol Besar Permanen,Buah,0,10000,0,0,10000,0,0,0,0,10000,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Tinta Printer Warna,buah,0,65700,0,0,65700,0,0,0,0,65700,0,0,0,
Februari 2026,Persediaan Alat Tulis Kantor,Tinta Printer Hitam,buah,1,58600,58600,0,58600,0,1,58600,0,58600,58600,1,58600,
Februari 2026,Persediaan Alat Tulis Kantor,Usb/Flash Disk - 32GB,buah,0,55000,0,0,55000,0,0,0,0,55000,0,0,0,
Februari 2026,Persediaan Benda Pos,Materai 10000,buah,0,10400,0,0,10400,0,0,0,0,10400,0,0,0,
Februari 2026,Persediaan Barang Cetakan Lainnya,Stopmap Lambang Lima Warna,buah,30,8300,249000,0,0,0,30,249000,10,7000,70000,20,179000,
Februari 2026,Persediaan Barang Cetakan Lainnya,Blangko SPPD NCR 4 Rangkap,buku,0,0,0,0,0,0,0,0,0,0,0,0,0,
Februari 2026,Persediaan Barang Cetakan Lainnya,Blangko Lambang Garuda,Set,380,2900,1102000,0,0,0,380,1102000,50,2800,140000,330,962000,
Februari 2026,Persediaan Barang Cetakan Lainnya,Blanko cetakan 1 folio kertas Doorslag warna 2 Muka,buku,0,0,0,0,0,0,0,0,0,0,0,0,0,
EOF;

        $lines = explode("\n", trim($csv));
        $header = str_getcsv(array_shift($lines));

        foreach ($lines as $line) {
            $row = str_getcsv($line);
            if (count($row) < 17) continue;

            $data = array_combine(array_slice($header, 0, 18), array_slice($row, 0, 18));
            
            // Map kategori and satuan
            $category = Category::firstOrCreate(['name' => $data['kategori']], ['code' => strtoupper(substr($data['kategori'], 0, 5))]);
            $unit = Unit::firstOrCreate(['name' => strtolower($data['satuan'])]);

            $item = Item::firstOrCreate(
                ['name' => $data['nama_barang']],
                [
                    'category_id' => $category->id,
                    'unit_id' => $unit->id,
                    'unit_price' => $data['pengadaan_harga_satuan'] > 0 ? $data['pengadaan_harga_satuan'] : $data['sisa_lalu_harga_satuan'],
                    'stock' => 0,
                    'simda_code' => 'S-' . rand(1000, 9999) // Auto generate dummy simda code
                ]
            );

            RekapPersediaan::updateOrCreate(
                [
                    'bulan' => $data['bulan'],
                    'item_id' => $item->id,
                ],
                [
                    'sisa_lalu_volume' => $data['sisa_lalu_volume'],
                    'sisa_lalu_harga_satuan' => $data['sisa_lalu_harga_satuan'],
                    'sisa_lalu_total' => $data['sisa_lalu_total'],
                    'pengadaan_volume' => $data['pengadaan_volume'],
                    'pengadaan_harga_satuan' => $data['pengadaan_harga_satuan'],
                    'pengadaan_total' => $data['pengadaan_total'],
                    'jumlah_volume' => $data['jumlah_volume'],
                    'jumlah_harga' => $data['jumlah_harga'],
                    'pemakaian_volume' => $data['pemakaian_volume'],
                    'pemakaian_harga_satuan' => $data['pemakaian_harga_satuan'],
                    'pemakaian_total' => $data['pemakaian_total'],
                    'sisa_volume' => $data['sisa_volume'],
                    'sisa_harga' => $data['sisa_harga'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }
    }
}

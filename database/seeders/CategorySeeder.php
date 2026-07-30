<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['code' => '1.1.5.1', 'name' => 'Barang Habis Pakai', 'description' => 'Barang habis pakai / ATK'],
            ['code' => '1.1.5.4', 'name' => 'Persediaan Benda Pos', 'description' => 'Benda pos seperti prangko, materai, dll'],
            ['code' => '1.1.5.7.4', 'name' => 'Persediaan Barang Cetakan Lainnya', 'description' => 'Barang cetakan instansi'],
            ['code' => '1.1.5.8', 'name' => 'Alat Elektronik', 'description' => 'Peralatan elektronik instansi'],
            ['code' => '1.1.5.9', 'name' => 'Kendaraan Bermotor', 'description' => 'Kendaraan dinas operasional'],
            ['code' => '1.1.5.10', 'name' => 'Mebeler', 'description' => 'Mebel, meja, kursi, dan lemari'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['code' => $category['code']], $category);
        }
    }
}

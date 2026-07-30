<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('useful_life')->nullable()->after('purchase_date');
            $table->decimal('residual_value', 15, 2)->default(0)->after('useful_life');
        });

        // Modifikasi tipe enum item_type secara manual karena Eloquent/Schema tidak mendukung langsung alter ENUM di beberapa database
        DB::statement("ALTER TABLE items MODIFY COLUMN item_type ENUM('Umum', 'Elektronik', 'Kendaraan', 'Mebeler') NOT NULL DEFAULT 'Umum'");

        // Pembaruan / penyisipan kategori sesuai permintaan user
        DB::table('categories')->updateOrInsert(
            ['code' => '1.1.5.1'],
            ['name' => 'Barang Habis Pakai', 'description' => 'Barang habis pakai / ATK', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('categories')->updateOrInsert(
            ['code' => '1.1.5.8'],
            ['name' => 'Alat Elektronik', 'description' => 'Peralatan elektronik instansi', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('categories')->updateOrInsert(
            ['code' => '1.1.5.9'],
            ['name' => 'Kendaraan Bermotor', 'description' => 'Kendaraan dinas operasional', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('categories')->updateOrInsert(
            ['code' => '1.1.5.10'],
            ['name' => 'Mebeler', 'description' => 'Mebel, meja, kursi, dan lemari', 'created_at' => now(), 'updated_at' => now()]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['useful_life', 'residual_value']);
        });

        DB::statement("ALTER TABLE items MODIFY COLUMN item_type ENUM('Umum', 'Elektronik', 'Kendaraan') NOT NULL DEFAULT 'Umum'");
        
        DB::table('categories')->where('code', '1.1.5.10')->delete();
    }
};

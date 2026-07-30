<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom-kolom detail inventaris sesuai format data SIMDA.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Kategori aset (INTRA KOMPATABEL / EKSTRA KOMPATABEL / ASET LAINNYA)
            $table->string('asset_category')->nullable()->after('id');

            // Nomor urut pendaftaran & register
            $table->string('registration_number')->nullable()->after('simda_code');
            $table->string('register_number')->nullable()->after('registration_number');

            // Merk/Type & Spesifikasi
            $table->string('brand_type')->nullable()->after('name');
            $table->string('size_spec')->nullable()->after('brand_type');
            $table->string('material')->nullable()->after('size_spec');

            // Detail Kendaraan
            $table->string('factory_number')->nullable()->after('material');
            $table->string('chassis_number')->nullable()->after('factory_number');
            $table->string('engine_number')->nullable()->after('chassis_number');
            $table->string('license_plate')->nullable()->after('engine_number');
            $table->string('bpkb_number')->nullable()->after('license_plate');

            // Lokasi & Asal Usul
            $table->string('location')->nullable()->after('bpkb_number');
            $table->string('acquisition_source')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn([
                'asset_category',
                'registration_number',
                'register_number',
                'brand_type',
                'size_spec',
                'material',
                'factory_number',
                'chassis_number',
                'engine_number',
                'license_plate',
                'bpkb_number',
                'location',
                'acquisition_source',
            ]);
        });
    }
};

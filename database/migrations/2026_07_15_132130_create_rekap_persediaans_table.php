<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekap_persediaans', function (Blueprint $table) {
            $table->id();
            $table->string('bulan'); // e.g., "Mei 2026"
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            
            // Sisa Lalu (Sisa Bulan Sebelumnya)
            $table->integer('sisa_lalu_volume')->default(0);
            $table->decimal('sisa_lalu_harga_satuan', 15, 2)->default(0);
            $table->decimal('sisa_lalu_total', 15, 2)->default(0);
            
            // Pengadaan Bulan Ini
            $table->integer('pengadaan_volume')->default(0);
            $table->decimal('pengadaan_harga_satuan', 15, 2)->default(0);
            $table->decimal('pengadaan_total', 15, 2)->default(0);
            
            // Jumlah (Sisa Lalu + Pengadaan)
            $table->integer('jumlah_volume')->default(0);
            $table->decimal('jumlah_harga', 15, 2)->default(0);
            
            // Pemakaian Bulan Ini
            $table->integer('pemakaian_volume')->default(0);
            $table->decimal('pemakaian_harga_satuan', 15, 2)->default(0);
            $table->decimal('pemakaian_total', 15, 2)->default(0);
            
            // Sisa Akhir
            $table->integer('sisa_volume')->default(0);
            $table->decimal('sisa_harga', 15, 2)->default(0);
            
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Unik per item per bulan
            $table->unique(['bulan', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_persediaans');
    }
};

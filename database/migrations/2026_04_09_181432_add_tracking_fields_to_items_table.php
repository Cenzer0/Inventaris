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
        Schema::table('items', function (Blueprint $table) {
            $table->enum('item_type', ['Umum', 'Elektronik', 'Kendaraan'])->default('Umum')->after('category_id');
            $table->date('purchase_date')->nullable()->after('item_type');
            $table->date('last_service_date')->nullable()->after('purchase_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['item_type', 'purchase_date', 'last_service_date']);
        });
    }
};

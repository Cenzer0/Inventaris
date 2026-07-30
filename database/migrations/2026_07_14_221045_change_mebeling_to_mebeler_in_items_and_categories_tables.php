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
        // 1. Update existing records in items table that have 'Mebeling'
        DB::table('items')->where('item_type', 'Mebeling')->update(['item_type' => 'Umum']);
        
        // 2. Change the ENUM definition
        DB::statement("ALTER TABLE items MODIFY COLUMN item_type ENUM('Umum', 'Elektronik', 'Kendaraan', 'Mebeler') NOT NULL DEFAULT 'Umum'");
        
        // 3. Update the temporary 'Umum' back to 'Mebeler' based on category
        DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->whereIn('categories.name', ['Mebeling', 'Mebeler'])
            ->update(['items.item_type' => 'Mebeler']);

        // 4. Update the Category name
        DB::table('categories')->where('name', 'Mebeling')->update(['name' => 'Mebeler']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items_and_categories_tables', function (Blueprint $table) {
            //
        });
    }
};

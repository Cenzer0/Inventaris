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
        // Require DBAL to change columns if needed, or simply use raw statement for safety if DBAL is not installed
        DB::statement('ALTER TABLE items MODIFY unit_price DECIMAL(15, 2) DEFAULT 0');
        DB::statement('ALTER TABLE inventory_transactions MODIFY unit_price DECIMAL(15, 2) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE items MODIFY unit_price DECIMAL(10, 2) DEFAULT 0');
        DB::statement('ALTER TABLE inventory_transactions MODIFY unit_price DECIMAL(10, 2) NULL');
    }
};

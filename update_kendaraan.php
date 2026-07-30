<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Item;
use Carbon\Carbon;

// Update Kendaraan to have last_service_date and tax_month
Item::where('item_type', 'Kendaraan')->update([
    'last_service_date' => Carbon::now()->subMonths(4), // 4 months ago (triggers service)
    'tax_month' => Carbon::now()->month, // this month (triggers tax)
]);

echo "Updated Kendaraan items\n";

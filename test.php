<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach(App\Models\Item::whereIn('item_type', ['Elektronik', 'Kendaraan', 'Mebeler'])->get() as $i) { 
    echo 'Name: '.$i->name.' | Price: '.$i->unit_price.' | Stock: '.$i->stock.' | Purchase: '.($i->purchase_date ? $i->purchase_date->format('Y-m-d') : 'NULL')."\n"; 
}

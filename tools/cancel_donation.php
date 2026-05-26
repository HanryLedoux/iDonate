<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Donation;
use App\Models\FoodItem;

$donation = Donation::find(1);
if(!$donation) { echo "no donation\n"; exit; }
$qty = $donation->quantity ?? 1;
$fi = $donation->foodItem;
if($fi){
    $fi->increment('quantity', $qty);
    if($fi->quantity > 0) $fi->update(['is_available' => true]);
}
$donation->status = 'cancelled';
$donation->save();

echo "cancelled donation 1\n";

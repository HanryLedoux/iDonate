<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Donation;

$donations = Donation::with('receiver')->get();
foreach($donations as $d){
    echo $d->id . ' | user_id=' . $d->user_id . ' | email=' . optional($d->receiver)->email . ' | qty=' . ($d->quantity ?? 1) . ' | status=' . $d->status . "\n";
}

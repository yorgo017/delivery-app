<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Driver;
use App\Models\Delivery;

Route::get('/', fn() => 'Laravel Working!');

Route::get('/test-delivery', function () {
    $user = User::factory()->create();
    $driver = Driver::create([
        'user_id' => $user->id,
        'license_number' => 'W123',
        'pricing_model' => 'fixed',
        'rate' => 10,
    ]);

    $delivery = Delivery::create([
        'user_id' => $user->id,
        'driver_id' => $driver->id,
        'pickup_location' => 'Beirut',
        'dropoff_location' => 'Tripoli',
        'package_weight' => 5,
        'status' => 'pending',
    ]);

    return $delivery;
});

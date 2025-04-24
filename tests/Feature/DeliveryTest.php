<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Driver;
use App\Models\Delivery;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_delivery_can_be_created()
    {
        $user = User::factory()->create();
        $driver = Driver::create([
            'user_id' => $user->id,
            'license_number' => 'AAA123',
            'pricing_model' => 'fixed',
            'rate' => 20,
        ]);

        $delivery = Delivery::create([
            'user_id' => $user->id,
            'driver_id' => $driver->id,
            'pickup_location' => 'Downtown',
            'dropoff_location' => 'Airport',
            'package_weight' => 5.5,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('deliveries', [
            'pickup_location' => 'Downtown',
            'status' => 'pending',
        ]);
    }
}

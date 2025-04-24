<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Driver;
use App\Models\Delivery;
use App\Models\Payment;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_can_be_created_for_delivery()
    {
        $user = User::factory()->create();
        $driver = Driver::create([
            'user_id' => $user->id,
            'license_number' => 'B123',
            'pricing_model' => 'per_km',
            'rate' => 10,
        ]);

        $delivery = Delivery::create([
            'user_id' => $user->id,
            'driver_id' => $driver->id,
            'pickup_location' => 'City A',
            'dropoff_location' => 'City B',
            'package_weight' => 3,
            'status' => 'in_progress',
        ]);

        $payment = Payment::create([
            'delivery_id' => $delivery->id,
            'amount' => 99.99,
            'method' => 'credit',
            'currency' => 'USD',
            'confirmed' => true,
        ]);

        $this->assertDatabaseHas('payments', [
            'amount' => 99.99,
            'confirmed' => true,
        ]);
    }
}

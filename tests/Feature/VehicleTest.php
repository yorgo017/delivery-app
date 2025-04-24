<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function test_vehicle_can_be_created_for_driver()
    {
        $user = User::factory()->create();
        $driver = Driver::create([
            'user_id' => $user->id,
            'license_number' => 'D999',
            'pricing_model' => 'fixed',
            'rate' => 15,
        ]);

        $vehicle = Vehicle::create([
            'driver_id' => $driver->id,
            'type' => 'bike',
            'plate_number' => 'XYZ123',
        ]);

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => 'XYZ123',
        ]);
    }
}

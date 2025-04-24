<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Driver;

class DriverTest extends TestCase
{
    use RefreshDatabase; // wipes DB between tests

    public function test_driver_can_be_created()
    {
        $user = User::factory()->create();

        $driver = Driver::create([
            'user_id' => $user->id,
            'license_number' => 'AB123',
            'pricing_model' => 'fixed',
            'rate' => 25,
        ]);

        $this->assertDatabaseHas('drivers', [
            'license_number' => 'AB123',
        ]);
    }
}

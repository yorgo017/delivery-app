<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Driver;
use App\Models\Delivery;

class DeliveryApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_register_new_client()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'user',
                     'token'
                 ]);
    }

    public function test_create_delivery_request()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/deliveries', [
            'pickup_location' => 'A',
            'dropoff_location' => 'B',
            'package_weight' => 2.5,
            'status' => 'pending'
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['pickup_location' => 'A']);
    }

    public function test_assign_driver_to_delivery()
    {
        $user = User::factory()->create();
        $driver = Driver::create([
            'user_id' => $user->id,
            'license_number' => 'ABC123',
            'pricing_model' => 'fixed',
            'rate' => 10,
        ]);

        $delivery = Delivery::create([
            'user_id' => $user->id,
            'pickup_location' => 'A',
            'dropoff_location' => 'B',
            'package_weight' => 2.5,
            'status' => 'pending'
        ]);

        $this->actingAs($user);

        $response = $this->patchJson("/api/deliveries/{$delivery->id}/assign", [
            'driver_id' => $driver->id
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['driver_id' => $driver->id]);
    }

    public function test_get_driver_details()
    {
        $user = User::factory()->create();
        $driver = Driver::create([
            'user_id' => $user->id,
            'license_number' => 'XYZ999',
            'pricing_model' => 'per_km',
            'rate' => 5,
        ]);

        $response = $this->getJson("/api/drivers/{$driver->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['license_number' => 'XYZ999']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->token = $loginResponse->json('access_token');
    }

    /**
     * Test accessing protected services routes.
     */
    public function test_accessing_protected_services_routes(): void
    {
        // Testing list all services
        $response = $this->getJson('/api/services', [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200);

        // Testing create a service
        $serviceData = [
            'name' => 'Test Service',
            'price' => 199.99,
        ];

        $response = $this->postJson('/api/services', $serviceData, [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Test Service',
                'price' => 199.99,
            ]);

        $serviceId = $response->json('id');

        // Testing view a single service
        $response = $this->getJson("/api/services/{$serviceId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Test Service',
                'price' => 199.99,
            ]);

        // Testing update a service
        $updatedData = [
            'name' => 'Updated Service',
            'price' => 299.99,
        ];

        $response = $this->putJson("/api/services/{$serviceId}", $updatedData, [
            'Authorization' => "Bearer {$this->token}",
        ]);

        // Check the response status and content
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Service updated successfully',
            ]);

        // Verify the service was updated correctly
        $response = $this->getJson("/api/services/{$serviceId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertJson([
            'name' => 'Updated Service',
            'price' => 299.99,
        ]);

        // Testing delete a service
        $response = $this->deleteJson("/api/services/{$serviceId}", [], [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Service deleted successfully',
            ]);

        // Verify the service was deleted
        $response = $this->getJson("/api/services/{$serviceId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(404);
    }
}

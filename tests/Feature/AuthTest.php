<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the registration route.
     *
     * @return void
     */
    public function test_registration_route(): void
    {
        $response = $this->postJson('api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'phone' => '1122334455'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test the login route.
     *
     * @return void
     */
    public function test_login_route(): void
    {
        User::factory()->create([
            'email' => 'userAuth@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('api/auth/login', [
            'email' => 'userAuth@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token'
            ]);
    }
}

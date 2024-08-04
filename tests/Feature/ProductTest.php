<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductTest extends TestCase
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
     * Test accessing protected products routes.
     */
    public function test_accessing_protected_products_routes(): void
    {
        // Testing list all products
        $response = $this->getJson('/api/products', [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200);

        // Testing create a product
        $productData = [
            'name' => 'Test Product',
            'price' => 99.99,
            'description' => 'This is a test product',
        ];

        $response = $this->postJson('/api/products', $productData, [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Test Product',
                'price' => 99.99,
                'description' => 'This is a test product',
            ]);

        $productId = $response->json('id');

        // Testing view a single product
        $response = $this->getJson("/api/products/{$productId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Test Product',
                'price' => 99.99,
                'description' => 'This is a test product',
            ]);

        // Testing update a product
        $updatedData = [
            'name' => 'Updated Product',
            'price' => 149.99,
            'description' => 'This is an updated product description',
        ];

        $response = $this->putJson("/api/products/{$productId}", $updatedData, [
            'Authorization' => "Bearer {$this->token}",
        ]);

        // Check the response status and content
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Product updated successfully',
            ]);

        // Verify the product was updated correctly
        $response = $this->getJson("/api/products/{$productId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertJson([
            'name' => 'Updated Product',
            'price' => 149.99,
            'description' => 'This is an updated product description',
        ]);

        // Testing delete a product
        $response = $this->deleteJson("/api/products/{$productId}", [], [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Product deleted successfully',
            ]);

        // Verify the product was deleted
        $response = $this->getJson("/api/products/{$productId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(404);
    }
}

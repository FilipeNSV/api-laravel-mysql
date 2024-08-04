<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TransactionTest extends TestCase
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
     * Test accessing protected transactions routes.
     */
    public function test_accessing_protected_transactions_routes(): void
    {
        // Testing list all transactions
        $response = $this->getJson('/api/transactions', [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200);

        $product = Product::factory()->create();

        // Testing create a transaction
        $transactionData = [
            'price' => 100.00,
            'quantity' => 2,
            'type' => 'entry',
            'user_id' => $this->user->id,
            'ownable_id' => $product->id,
            'ownable_type' => Product::class,
        ];

        $response = $this->postJson('/api/transactions', $transactionData, [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(201);

        $transactionId = $response->json('id');

        // Testing view a single transaction        
        $response = $this->getJson("/api/transactions/{$transactionId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200);

        // Testing update a transaction
        $updatedData = [
            'price' => 150.00,
            'quantity' => 2,
            'type' => 'exit', // Changed type for the sake of testing
            'user_id' => $this->user->id,
            'ownable_id' => $product->id,
            'ownable_type' => Product::class,
        ];

        $response = $this->putJson("/api/transactions/{$transactionId}", $updatedData, [
            'Authorization' => "Bearer {$this->token}",
        ]);

        // Check the response status and content
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Transaction updated successfully',
            ]);

        // Verify the transaction was updated correctly
        $response = $this->getJson("/api/transactions/{$transactionId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertJson([
            'price' => 150.00,
            'quantity' => 2,
            'type' => 'exit', // Check
            'user_id' => $this->user->id,
            'ownable_id' => $product->id,
            'ownable_type' => Product::class,
        ]);

        // Testing delete a transaction
        $response = $this->deleteJson("/api/transactions/{$transactionId}", [], [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Transaction deleted successfully',
            ]);

        // Verify the transaction was deleted
        $response = $this->getJson("/api/transactions/{$transactionId}", [
            'Authorization' => "Bearer {$this->token}",
        ]);
        $response->assertStatus(404);
    }
}

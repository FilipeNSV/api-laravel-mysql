<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of a transaction using the factory.
     *
     * @return void
     */
    public function test_transaction_creation(): void
    {
        // Create a user, product, and service using the factories
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $service = Service::factory()->create();

        // Create a transaction using the factory
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'ownable_id' => $product->id,
            'ownable_type' => Product::class,
        ]);

        // Check if the transaction was created and has the expected attributes
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'price' => $transaction->price,
            'quantity' => $transaction->quantity,
            'type' => $transaction->type,
            'user_id' => $user->id,
            'ownable_id' => $product->id,
            'ownable_type' => Product::class,
        ]);

        // Verify that the transaction can be associated with a product
        $this->assertInstanceOf(Product::class, $transaction->ownable);

        // Now, test with a service
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'ownable_id' => $service->id,
            'ownable_type' => Service::class,
        ]);

        // Check if the transaction was created and has the expected attributes
        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'price' => $transaction->price,
            'quantity' => $transaction->quantity,
            'type' => $transaction->type,
            'user_id' => $user->id,
            'ownable_id' => $service->id,
            'ownable_type' => Service::class,
        ]);

        // Verify that the transaction can be associated with a service
        $this->assertInstanceOf(Service::class, $transaction->ownable);
    }
}

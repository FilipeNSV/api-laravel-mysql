<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of a product using the factory.
     *
     * @return void
     */
    public function test_product_creation(): void
    {
        // Create a product using the factory
        $product = Product::factory()->create();

        // Check if the product was created and has the expected attributes
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
        ]);
    }
}

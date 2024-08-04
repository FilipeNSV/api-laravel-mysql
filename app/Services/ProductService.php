<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * Get all products.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllProducts()
    {
        return Product::all();
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function findProductById(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Update a product.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateProduct(int $id, array $data): bool
    {
        $product = Product::find($id);

        if ($product) {
            return $product->update($data);
        }

        return false;
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        $product = Product::find($id);

        if ($product) {
            return $product->delete();
        }

        return false;
    }
}

<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::query()->where('is_admin', false)->inRandomOrder()->value('id') ?? User::factory()->create()->id;
        $ownableType = $this->faker->randomElement([Product::class, Service::class]);
        $ownableId = $ownableType::query()->inRandomOrder()->value('id') ?? $ownableType::factory()->create()->id;

        return [
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'type' => $this->faker->randomElement(['entry', 'exit']),
            'user_id' => $userId,
            'ownable_id' => $ownableId,
            'ownable_type' => $ownableType,
        ];
    }
}

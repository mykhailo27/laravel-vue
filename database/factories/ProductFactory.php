<?php

namespace Database\Factories;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    use HasUuids;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'id' => $this->newUniqueId(),
            'name' => $this->faker->name,
            'sku' => $this->faker->uuid,
            'desc' => $this->faker->sentence,
            'price' => random_int(20, 50)
        ];
    }
}

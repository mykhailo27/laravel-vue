<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => $this->faker->uuid
        ];
    }

    public function configure(): VariantFactory
    {
        return $this->afterMaking(function (Variant $variant) {
            $product = $this->getProduct();

            $variant->product_id = $product->id;
        });
    }

    private function getProduct(): Product
    {
        $product = Product::inRandomOrder()->first();

        if ($product instanceof Product) {
            return $product;
        }

        return Product::factory()->create();
    }
}

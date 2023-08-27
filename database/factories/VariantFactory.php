<?php

namespace Database\Factories;

use App\Http\Controllers\Color\ColorModelController;
use App\Http\Controllers\Inventory\InventoryModelController;
use App\Http\Controllers\Size\SizeModelController;
use App\Http\Controllers\Variation\VariationModelController;
use App\Models\Closet;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Throwable;

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
        $product = $this->getProduct();

        return [
            'sku' => $this->faker->uuid,
            'product_id' => $product->id
        ];
    }

    public function configure(): VariantFactory
    {
        return $this->afterCreating(function (Variant $variant) {
            $this->createSizeVariation($variant);
            $this->createColorVariation($variant);
            $this->createInventory($variant);
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

    /**
     * @param Variant $variant
     * @return void
     * @throws Throwable
     */
    function createSizeVariation(Variant $variant): void
    {
        $size = SizeModelController::randomFirst();
        throw_if(is_null($size));

        VariationModelController::createFor($variant, $size);
    }

    /**
     * @param Variant $variant
     * @return void
     * @throws Throwable
     */
    function createColorVariation(Variant $variant): void
    {
        $color = ColorModelController::randomFirst();
        throw_if(is_null($color));

        VariationModelController::createFor($variant, $color);
    }

    private function createInventory(Variant $variant): void
    {
        /** @var Closet $closet */
        $closet = Closet::inRandomOrder()->first()
            ?: Closet::factory()->create();

        InventoryModelController::createForVariant($variant, $closet);
    }
}

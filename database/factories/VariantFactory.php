<?php

namespace Database\Factories;

use App\Http\Controllers\Inventory\InventoryModelController;
use App\Http\Controllers\Variation\VariationModelController;
use App\Http\Controllers\Color\ColorModelController;
use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Controllers\Size\SizeModelController;
use App\Models\Product;
use App\Models\Variant;
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
        /** @var Company $company */
        $company = Company::inRandomOrder()->first()
            ?: Company::factory()->create();

        $closet = $company->generalCloset();

        try {
            $quantity = random_int(1, 5);
        } catch (Exception $e) {
            $quantity = 1;
        }

        InventoryModelController::createForVariant($variant, $closet, $quantity);
    }
}

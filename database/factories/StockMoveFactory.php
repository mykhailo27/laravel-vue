<?php

namespace Database\Factories;

use App\Http\Controllers\Warehouse\WarehouseModelController;
use App\Http\Controllers\Company\CompanyModelController;
use App\Http\Controllers\Variant\VariantModelController;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\StockMoveType;
use App\Models\StockMove;
use App\Models\Warehouse;
use App\Models\Company;
use App\Models\Variant;

/**
 * @extends Factory<StockMove>
 */
class StockMoveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = StockMoveType::values();

        return [
            'type' => $types[array_rand($types)],
            'variant_id' => $this->attachToVariant(),
            'closet_id' => $this->getClosetId(),
            'warehouse_id' => $this->attachToWarehouse(),
        ];
    }

    private function getClosetId(): string
    {
        $company = CompanyModelController::RandomFirst()
            ?: Company::factory()->create();

        $closet = $company->generalCloset();

        return $closet->id;
    }

    private function attachToWarehouse(): string
    {
        $warehouse = warehouseModelController::RandomFirst()
            ?: Warehouse::factory()->create();

        return $warehouse->id;
    }

    private function attachToVariant(): int
    {
        $variant = VariantModelController::RandomFirst()
            ?: Variant::factory()->create();

        return $variant->id;
    }
}

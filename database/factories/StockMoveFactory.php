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
            'type' => $types[array_rand($types)]
        ];
    }

    public function configure(): StockMoveFactory
    {
        return $this->afterMaking(function (StockMove $stock_move) {

            $this->attachToCompany($stock_move);
            $this->attachToWarehouse($stock_move);
            $this->attachToVariant($stock_move);

        });
    }

    private function attachToCompany(StockMove $stock_move): void
    {
        $company = CompanyModelController::RandomFirst()
            ?: Company::factory()->create();

        $stock_move->company_id = $company->id;
    }

    private function attachToWarehouse(StockMove $stock_move): void
    {
        $warehouse = warehouseModelController::RandomFirst()
            ?: Warehouse::factory()->create();

        $stock_move->warehouse_id = $warehouse->id;
    }

    private function attachToVariant(StockMove $stock_move): void
    {
        $variant = VariantModelController::RandomFirst()
            ?: Variant::factory()->create();

        $stock_move->variant_id = $variant->id;
    }
}

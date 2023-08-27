<?php

namespace Database\Factories;

use App\Http\Controllers\Closet\ClosetModelController;
use App\Http\Controllers\Inventory\InventoryModelController;
use App\Http\Controllers\Warehouse\WarehouseModelController;
use App\Http\Controllers\Variant\VariantModelController;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\StockMoveType;
use App\Models\StockMove;
use App\Models\Warehouse;
use App\Models\Variant;
use App\Models\Closet;

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

        /** @var StockMoveType $type */
        $type = $types[array_rand($types)];

        $warehouse = $this->getWarehouse();
        $closet = $this->getClosetBy($warehouse);
        $variant = $this->getVariant();

        return [
            'type' => $type,
            'variant_id' => $variant->id,
            'closet_id' => $closet->id,
            'warehouse_id' => $warehouse->id,
        ];
    }

    public function configure(): StockMoveFactory
    {
        return $this->afterCreating(function (StockMove $stock_move) {
            $inventory = InventoryModelController::getByStockMove($stock_move);
            if (is_null($inventory)) {
                $inventory = InventoryModelController::createForVariant($stock_move->variant, $stock_move->closet);
            }

            InventoryModelController::updateInventoryQuantity($inventory, $stock_move);
        });
    }

    private function getClosetBy(Warehouse $warehouse): Closet
    {
        $closet = ClosetModelController::getByWarehouse($warehouse);

        if (is_null($closet)) {
            $closet = Closet::factory()->create(['warehouse_id' => $warehouse->id]);
        }

        return $closet;
    }

    private function getWarehouse(): Warehouse
    {
        return warehouseModelController::RandomFirst()
            ?: Warehouse::factory()->create();
    }

    private function getVariant(): Variant
    {
        return VariantModelController::RandomFirst()
            ?: Variant::factory()->create();
    }
}

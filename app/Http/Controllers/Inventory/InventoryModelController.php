<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\StockMoveType;
use App\Http\Controllers\Controller;
use App\Models\Closet;
use App\Models\Inventory;
use App\Models\StockMove;
use App\Models\Variant;

class InventoryModelController extends Controller
{
    public static function update(Inventory $inventory, array $attributes): bool
    {
        return $inventory->update($attributes);
    }

    public static function getByStockMove(StockMove $stock_move): ?Inventory
    {
        /** @var Inventory $inventory */
        $inventory = $stock_move
            ->variant
            ->inventories()
            ->where('closet_id', '=', $stock_move->closet_id)
            ->first();

        return $inventory;
    }

    public static function createForVariant(Variant $variant, Closet $closet, int $quantity = 0): Inventory
    {
        return self::create([
            'closet_id' => $closet->id,
            'variant_id' => $variant->id,
            'in_stock' => $quantity
        ]);
    }

    private static function create(array $attributes): Inventory
    {
        return Inventory::create($attributes);
    }

    public static function getByVariant(Variant $variant, Closet $closet): ?Inventory
    {
        /** @var Inventory $inventory */
        $inventory = $variant->inventories()
            ->where('closet_id', '=', $closet->id)
            ->first();

        return $inventory;
    }

    public static function updateInventoryQuantity(Inventory $inventory, StockMove $stock_move): bool
    {
        $attribute = match ($stock_move->type) {
            StockMoveType::SENT => ['in_transit' => $inventory->in_transit + $stock_move->amount],
            StockMoveType::RECEIVED => [
                'in_stock' => $inventory->in_stock + $stock_move->amount,
                'in_transit' => $inventory->in_transit - $stock_move->amount,
            ],
            default => []
        };

        return InventoryModelController::update($inventory, $attribute);
    }
}

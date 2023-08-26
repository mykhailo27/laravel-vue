<?php

namespace App\Http\Controllers\Inventory;

use App\Enums\InventoryType;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\StockMove;

class InventoryModelController extends Controller
{
    public static function update(Inventory $inventory, array $attributes): bool
    {
        return $inventory->update($attributes);
    }

    public static function firstOrCreateFromStockMove(StockMove $stock_move): Inventory
    {
        return Inventory::firstOrCreate([
            'type' => InventoryType::IN_STOCK,
            'closet_id' => $stock_move->closet_id,
            'variant_id' => $stock_move->variant_id
        ], [
            'quantity' => $stock_move->amount
        ]);
    }

    private static function create(array $attributes): Inventory
    {
        return Inventory::create($attributes);
    }
}

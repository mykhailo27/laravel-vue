<?php

namespace App\Listeners;

use App\Events\StockMoveProcessed;
use App\Http\Controllers\Inventory\InventoryModelController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessInventory implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StockMoveProcessed $event): void
    {
        $stock_move = $event->stock_move;
        $inventory = InventoryModelController::getByStockMove($stock_move);

        $update = InventoryModelController::updateInventoryQuantity($inventory, $stock_move);

        Log::debug('$inventory ' . print_r($inventory, true));

        if ($update) {
            Log::debug('inventory stock updated ' . print_r($inventory->in_stock, true));
        } else {
            Log::debug('stock move fail update inventory' . print_r($stock_move, true));
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(StockMoveProcessed $event, Throwable $exception): void
    {
        // ...
    }
}

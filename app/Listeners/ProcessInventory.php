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
        $inventory = InventoryModelController::firstOrCreateFromStockMove($stock_move);

        $update = InventoryModelController::update($inventory, [
            'quantity' => $stock_move->amount
        ]);

        if ($update) {
            Log::debug('$inventory updated ' . print_r($inventory, true));
        } else {
            Log::debug('$stock_move ' . print_r($stock_move, true));
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

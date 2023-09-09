<?php

namespace App\Observers;

use App\Events\InventoryStockUpdate;
use App\Models\Inventory;

class InventoryObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Inventory $inventory): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Inventory $inventory): void
    {
        if ($inventory->isDirty('in_stock')) {
            InventoryStockUpdate::dispatch($inventory);
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Inventory $inventory): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Inventory $inventory): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Inventory $inventory): void
    {
        //
    }
}

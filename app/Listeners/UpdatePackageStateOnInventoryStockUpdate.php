<?php

namespace App\Listeners;

use App\Events\InventoryStockUpdate;
use App\Http\Controllers\Package\PackageModelController;
use App\Http\Controllers\Variant\VariantModelController;
use App\Models\Package;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatePackageStateOnInventoryStockUpdate implements ShouldQueue
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
    public function handle(InventoryStockUpdate $event): void
    {
        $inventory = $event->inventory;
        $variant = $inventory->variant;

        VariantModelController::getPackageInCloset($variant, $inventory->closet)
            ->map(function (Package $package) use ($inventory) {
                PackageModelController::processStateUpdate($package, $inventory);
            });
    }
}

<?php

namespace App\Observers;

use App\Http\Controllers\Package\PackageModelController;
use App\Http\Controllers\Variant\VariantModelController;
use App\Models\PackageVariant;

class PackageVariantObserver
{
    /**
     * Handle the PackageVariant "created" event.
     */
    public function created(PackageVariant $package_variant): void
    {
        $package = $package_variant->package;
        $inventory = VariantModelController::getInventoryInCloset($package_variant->variant, $package->closet);
        PackageModelController::processStateUpdate($package, $inventory);
    }

    /**
     * Handle the PackageVariant "updated" event.
     */
    public function updated(PackageVariant $packageVariant): void
    {
        //
    }

    /**
     * Handle the PackageVariant "deleted" event.
     */
    public function deleted(PackageVariant $packageVariant): void
    {
        //
    }

    /**
     * Handle the PackageVariant "restored" event.
     */
    public function restored(PackageVariant $packageVariant): void
    {
        //
    }

    /**
     * Handle the PackageVariant "force deleted" event.
     */
    public function forceDeleted(PackageVariant $packageVariant): void
    {
        //
    }
}

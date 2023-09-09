<?php

namespace App\Http\Controllers\Package;

use App\Enums\PackageState;
use App\Http\Controllers\Variant\VariantModelController;
use App\Models\Closet;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Package;
use App\Models\Variant;

class PackageModelController extends Controller
{

    public static function getVariantsInClosetNotInPackage(Closet $closet, Package $package)
    {
        return Variant::whereHas('inventories', function ($query) use ($closet) {
            $query->where('closet_id', $closet->id);
        })->whereDoesntHave('packages', function ($query) use ($package) {
            $query->where('package_id', $package->id);
        })->get();
    }

    public static function addVariant(Package $package, Variant $variant): bool
    {
        $package->variants()->syncWithoutDetaching($variant);

        return self::hasVariant($package, $variant);
    }

    private static function hasVariant(Package $package, Variant $variant): bool
    {
        return $package->variants()
            ->wherePivot('variant_id', '=', $variant->id)
            ->exists();
    }

    public static function delete(mixed $ids): int
    {
        return Package::destroy($ids);
    }

    public static function getById(string $id): ?Package
    {
        return Package::find($id);
    }

    public static function removeVariant(Package $package, Variant $variant): int
    {
        return $package->variants()
            ->detach($variant->id);
    }

    public static function processStateUpdate(Package $package, Inventory $inventory): bool
    {
        $stocked_variants_count = 0;

        if ($inventory->in_stock > 0) {
            $stocked_variants_count++;
        }

        $package->variants()
            ->whereNot('id', '=', $inventory->variant_id)
            ->each(function (Variant $variant) use ($package, &$stocked_variants_count) {
                /** @var Inventory $inventory */
                $inventory = VariantModelController::getInventoryInCloset($variant, $package->closet);
                if ($inventory->in_stock > 0) {
                    $stocked_variants_count++;
                }
            });

        if ($stocked_variants_count === 0) {
            $state = PackageState::UNSTOCKED;
        } elseif ($stocked_variants_count === $package->variants()->count()) {
            $state = PackageState::STOCKED;
        } else {
            $state = PackageState::PARTIALLY;
        }

        return PackageModelController::updateState($package, $state);
    }

    private static function updateState(Package $package, PackageState $state): bool
    {
        $package->state = $state;

        $package->save();
        $package->refresh();

        return $package->state === $state;
    }
}

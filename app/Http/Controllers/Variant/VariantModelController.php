<?php

namespace App\Http\Controllers\Variant;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Shipment;
use App\Models\Variant;
use App\Models\Closet;

class VariantModelController extends Controller
{
    public static function delete(mixed $ids): int
    {
        return Variant::destroy($ids);
    }

    public static function getById(string $id): Variant
    {
        return Variant::find($id);
    }

    public static function create(array $attributes): Variant
    {
        return Variant::create($attributes);
    }

    public static function RandomFirst(): ?Variant
    {
        return Variant::inRandomOrder()->first();
    }

    public static function getAll(): Collection
    {
        return Variant::all();
    }

    public static function getPackageInCloset(Variant $variant, Closet $closet): Collection
    {
        return $variant->packages()
            ->where('closet_id', $closet->id)
            ->get();
    }

    public static function getInventoryInCloset(Variant $variant, Closet $closet): ?Inventory
    {
        /** @var Inventory $inventory */
        $inventory = $variant->inventories()
            ->where('closet_id', '=', $closet->id)
            ->first();

        return $inventory;
    }

    public static function getVariantsInCloset(Closet $closet, array $columns = ['*']): Collection
    {
        return Variant::whereHas('inventories', function ($query) use ($closet) {
            $query->where('closet_id', $closet->id);
        })->get($columns);
    }

    public static function getVariantsInClosetNotInShipment(Shipment $shipment, array $column = ['*']): Collection
    {
        $closet = $shipment->closet;

        return Variant::whereHas('inventories', function ($query) use ($closet) {
            $query->where('closet_id', $closet->id);
        })->whereDoesntHave('shipments', function ($query) use ($shipment) {
            $query->where('shipment_id', $shipment->id);
        })->get($column);
    }
}

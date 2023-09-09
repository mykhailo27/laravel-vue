<?php

namespace App\Http\Controllers\Variant;

use App\Http\Controllers\Controller;
use App\Models\Closet;
use App\Models\Inventory;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Collection;

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
}

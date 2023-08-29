<?php

namespace App\Http\Controllers\Variant;

use App\Http\Controllers\Controller;
use App\Models\Closet;
use App\Models\Product;
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

    public static function getByCloset(Product $product, Closet $closet): Collection
    {
        return $product->variantsByCloset($closet)
            ->select('variants.*', 'inventories.in_stock', 'inventories.in_reserve', 'inventories.in_transit')
            ->get();
    }
}

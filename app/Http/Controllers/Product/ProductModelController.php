<?php

namespace App\Http\Controllers\Product;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Closet;

class ProductModelController extends Controller
{
    /**
     * @param mixed $ids
     * @note param could be single id or ids
     * @return int
     */
    public static function delete(mixed $ids): int
    {
        return Product::destroy($ids);
    }

    public static function getById(string $id): Product
    {
        return Product::find($id);
    }

    public static function getByCloset(Product $product, Closet $closet): Collection
    {
        return $product->variantsByCloset($closet)
            ->select('variants.*', 'inventories.in_stock', 'inventories.in_reserve', 'inventories.in_transit')
            ->get();
    }
}

<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

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

    public static function getVariants(Product $product): Collection
    {
        return $product->variants()
            ->get();
    }
}

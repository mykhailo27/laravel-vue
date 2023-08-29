<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Closet;
use App\Models\Product;

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

    public static function queryByCloset(Closet $closet)
    {
        return Product::whereHas('variants', function ($query) use ($closet) {
            $query->whereHas('inventories', function ($sub_query) use ($closet) {
                $sub_query->whereHas('closet', function ($subQuery) use ($closet) {
                    $subQuery->where('id', $closet->id);
                });
            });
        });
    }
}

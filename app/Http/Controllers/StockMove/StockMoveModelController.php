<?php

namespace App\Http\Controllers\StockMove;

use App\Http\Controllers\Controller;
use App\Models\StockMove;

class StockMoveModelController extends Controller
{
    public static function getById(int $id)
    {
        return StockMove::find($id);
    }

    public static function delete(mixed $ids): int
    {
        return StockMove::destroy($ids);
    }

    public static function update(StockMove $stock_move, array $attribute): bool
    {
        return $stock_move->update($attribute);
    }

    public static function create(array $attributes): ?StockMove
    {
        return StockMove::create($attributes);
    }
}

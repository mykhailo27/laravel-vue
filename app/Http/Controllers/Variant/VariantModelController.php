<?php

namespace App\Http\Controllers\Variant;

use App\Http\Controllers\Controller;
use App\Models\Variant;

class VariantModelController extends Controller
{
    /**
     * @param mixed $ids
     * @note param could be single id or ids
     * @return int
     */
    public static function delete(mixed $ids): int
    {
        return Variant::destroy($ids);
    }

    public static function getById(string $id): Variant
    {
        return Variant::find($id);
    }
}

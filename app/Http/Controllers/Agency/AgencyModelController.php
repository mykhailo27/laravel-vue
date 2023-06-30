<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;

class AgencyModelController extends Controller
{
    /**
     * @param mixed $ids
     * @note param could be single id or ids
     * @return int
     */
    public static function delete(mixed $ids): int
    {
        return Agency::destroy($ids);
    }

    public static function getById(string $id): Agency
    {
        return Agency::find($id);
    }
}

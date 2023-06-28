<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Agency;

class AgencyModelController extends Controller
{
    public static function deleteByIds(array $ids): int
    {
        return Agency::destroy($ids);
    }
}

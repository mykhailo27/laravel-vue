<?php

namespace App\Http\Controllers\Country;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryModelController extends Controller
{
    public static function getAll(): Collection
    {
        return Country::all();
    }
}

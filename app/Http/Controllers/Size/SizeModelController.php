<?php

namespace App\Http\Controllers\Size;

use App\Http\Controllers\Controller;
use App\Models\Attributes\Size;

class SizeModelController extends Controller
{
    public static function getById(string $id): ?Size
    {
        return Size::find($id);
    }

    public static function randomFirst(): ?Size
    {
        return Size::inRandomOrder()->first();
    }
}

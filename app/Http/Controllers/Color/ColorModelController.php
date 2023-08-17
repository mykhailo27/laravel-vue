<?php

namespace App\Http\Controllers\Color;

use App\Http\Controllers\Controller;
use App\Models\Attributes\Color;

class ColorModelController extends Controller
{
    public static function getById(string $id): ?Color
    {
        return Color::find($id);
    }

    public static function randomFirst(): ?Color
    {
        return Color::inRandomOrder()->first();
    }
}

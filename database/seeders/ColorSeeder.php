<?php

namespace Database\Seeders;

use App\Enums\ColorEnum;
use App\Models\Attributes\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        array_map(function (ColorEnum $color) {
            Color::create([
                'name' => $color->name,
                'value' => $color->value
            ]);
        }, ColorEnum::cases());
    }
}

<?php

namespace Database\Seeders;

use App\Enums\SizeEnum;
use App\Models\Attributes\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        array_map(function (SizeEnum $size) {
            Size::create([
                'name' => $size->name,
                'value' => $size->value
            ]);
        }, SizeEnum::cases());
    }
}

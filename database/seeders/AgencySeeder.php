<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agency::factory()
            ->count(5)
            ->create();
    }
}

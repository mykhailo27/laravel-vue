<?php

namespace Database\Seeders;

use App\Http\Controllers\Company\CompanyModelController;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createAdmin();

        $this->call([
            AgencySeeder::class,
            CountrySeeder::class,
            CompanySeeder::class,
            ClosetSeeder::class,
            UserSeeder::class,
            RolesAndPermissionsSeeder::class,
            WarehouseSeeder::class,
        ]);
    }

    /**
     * @return void
     */
    public function createAdmin(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        /** @var Company $company */
        $company = Company::factory()->create([
            'name' => 'IT Future'
        ]);

        CompanyModelController::addUser($company, $user);
        CompanyModelController::select($user, $company);
    }
}

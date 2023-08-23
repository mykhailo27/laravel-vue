<?php

namespace Database\Seeders;

use App\Http\Controllers\Company\CompanyModelController;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;

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
            ProductSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            VariantSeeder::class,
            StockMoveSeeder::class
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

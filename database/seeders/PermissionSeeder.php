<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('right.permissions') as $permission) {

            foreach (config('auth.guards') as $name => $guard_name) {

                Permission::create([
                    'name' => $permission,
                    'guard_name' => $name
                ]);
            }
        }
    }
}

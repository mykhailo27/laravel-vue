<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('right.roles') as $role) {
            foreach (config('auth.guards') as  $name => $guard_name) {
                Role::create([
                    'name' => $role,
                    'guard_name' => $name
                ]);
            }
        }
    }
}

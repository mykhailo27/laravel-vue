<?php

namespace Database\Seeders;

use App\Constants\Permission as PermissionConstant;
use App\Constants\Role as RoleConstant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    use WithoutModelEvents;

    private array $guard_names = ['web'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        App::make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->seedPermissions();
        $this->seedRoles();
    }

    private function seedPermissions(): void
    {
        $models = collect(['agency', 'user']);
        $prefixes = PermissionConstant::getConstants();

        $models->map(function ($model) use ($prefixes) {

            collect($prefixes)->map(function ($prefix) use ($model) {

                $attributes = collect($this->guard_names)
                    ->map(function ($guard_name) use ($prefix, $model) {
                        return ['name' => $prefix . $model, 'guard_name' => $guard_name];
                    });

                Permission::insert($attributes->toArray());
            });
        });
    }

    private function seedRoles(): void
    {
        $names = RoleConstant::getConstants();

        collect($names)->map(function ($name) {

            $attributes = collect($this->guard_names)
                ->map(function ($guard_name) use ($name) {
                    return ['name' => $name, 'guard_name' => $guard_name];
                });

            Role::insert($attributes->toArray());
        });
    }
}

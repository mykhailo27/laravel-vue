<?php

namespace Database\Seeders;

use App\Constants\Permission as PermissionConstant;
use App\Constants\Role as RoleConstant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use App\Models\Permission;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    use WithoutModelEvents, HasUuids;

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
        $models = collect(['agency', 'user', 'company', 'address', 'warehouse', 'country']);
        $prefixes = PermissionConstant::getConstants();

        $models->map(function ($model) use ($prefixes) {

            collect($prefixes)->map(function ($prefix) use ($model) {

                $attributes = collect($this->guard_names)
                    ->map(function ($guard_name) use ($prefix, $model) {
                        return [
                            'id' => $this->newUniqueId(),
                            'name' => $prefix . $model,
                            'guard_name' => $guard_name
                        ];
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
                    return [
                        'id' => $this->newUniqueId(),
                        'name' => $name,
                        'guard_name' => $guard_name
                    ];
                });

            Role::insert($attributes->toArray());
        });
    }
}

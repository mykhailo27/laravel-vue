<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class UserApiController extends Controller
{
    public function roles(User $user): Response
    {
        return response([
            'success' => true,
            'message' => 'Load agency users',
            'roles' => $user->roles
        ]);
    }

    public function addRole(User $user, Role $role): Response
    {
        $has_role = $user->assignRole($role);

        return response([
            'message' => $has_role->exists
                ? 'Role has been added successful'
                : 'Fail to add role to a user',
            'success' => $has_role->exists,
            'role' => $role
        ]);
    }

    public function removeRole(User $user, Role $role): Response
    {
        $has_role = $user->removeRole($role);

        $removed = !$has_role->exists;

        return response([
            'message' => $removed
                ? 'Role has been removed successful'
                : 'Fail to remove role from a user',
            'success' => $removed,
            'role' => $role
        ]);
    }
}

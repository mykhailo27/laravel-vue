<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserApiController extends Controller
{
    public function roles(User $user): Response
    {
        return response([
            'success' => true,
            'message' => 'Load user roles',
            'roles' => $user->roles
        ]);
    }

    public function addRole(User $user, Role $role): Response
    {
        $user->assignRole($role);

        $assigned = $user->hasRole($role);

        return response([
            'message' => $assigned
                ? 'Role has been added successful'
                : 'Fail to add role to a user',
            'success' => $assigned,
            'role' => $role
        ]);
    }

    public function removeRole(User $user, Role $role): Response
    {
        $user->removeRole($role);

        $removed = !$user->hasRole($role);

        return response([
            'message' => $removed
                ? 'Role has been removed successful'
                : 'Fail to remove role from a user',
            'success' => $removed,
            'role' => $role
        ]);
    }

    public function addPermission(User $user, Permission $permission): Response
    {
        $user->givePermissionTo($permission);

        $assigned = $user->hasPermissionTo($permission);

        return response([
            'message' => $assigned
                ? 'Permission has been added successful'
                : 'Fail to add permission to a user',
            'success' => $assigned,
            'permission' => $permission
        ]);
    }

    public function removePermission(User $user, Permission $permission): Response
    {
        $user->revokePermissionTo($permission);

        $removed = !$user->hasPermissionTo($permission);

        return response([
            'message' => $removed
                ? 'Permission has been removed successful'
                : 'Fail to remove permission from a user',
            'success' => $removed,
            'permission' => $permission
        ]);
    }
}

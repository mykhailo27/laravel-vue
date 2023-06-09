<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleApiController extends Controller
{
    public function permissions(Role $role): Response
    {
        return response([
            'success' => true,
            'message' => 'Load user roles',
            'permissions' => $role->permissions
        ]);
    }

    public function addPermission(Role $role, Permission $permission): Response
    {
        $role->givePermissionTo($permission);

        $assigned = $role->hasPermissionTo($permission);

        return response([
            'message' => $assigned
                ? 'Permission has been added successful'
                : 'Fail to add permission to a role',
            'success' => $assigned,
            'permission' => $permission
        ]);
    }

    public function removePermission(Role $role, Permission $permission): Response
    {
        $role->revokePermissionTo($permission);

        $removed = !$role->hasPermissionTo($permission);

        return response([
            'message' => $removed
                ? 'Permission has been removed successful'
                : 'Fail to remove permission from a role',
            'success' => $removed,
            'permission' => $permission
        ]);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Constants\Ability;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Permission;
use App\Models\Role;

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

    public function assignRole(User $user, Role $role): Response
    {
        $user->assignRole($role);

        $assigned = $user->hasRole($role);

        return response([
            'message' => $assigned
                ? 'Role has been assigned successful'
                : 'Fail to assign role to a user',
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

    public function givePermission(User $user, Permission $permission): Response
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

    public function delete(Request $request): Response
    {
        try {
            $user = UserModelController::getById($request->get('id'));

            $this->authorize(Ability::DELETE, $user);

            $deleted = UserModelController::delete($user->id);
            return response([
                'success' => $deleted,
                'message' => $deleted ? 'User deleted' : 'User fail to be deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }

    }

    public function deleteMultiple(Request $request): Response
    {
        try {
            $this->authorize(Ability::DELETE_ANY, User::class);

            $ids = $request->get('ids');
            $deleted = UserModelController::delete($ids);
            $success = $deleted === count($ids);

            return response([
                'success' => $success,
                'message' => $success ? 'All users deleted' : 'Some users deleted',
            ]);
        } catch (AuthorizationException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

}

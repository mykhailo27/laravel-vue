<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class UserApiController extends Controller
{
    public function index(): Response
    {
        return response([
            'success' => true,
            'message' => 'Load agency users',
            'users' => User::paginate(10)->onEachSide(0)
        ]);
    }
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
}

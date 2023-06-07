<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class UserApiController extends Controller
{
    public function index(Request $request): UserCollection
    {
        $search = $request->get('search');

        $users = User::where(static function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        })
            ->paginate(10)
            ->onEachSide(0);

        return new UserCollection($users);
    }

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
}

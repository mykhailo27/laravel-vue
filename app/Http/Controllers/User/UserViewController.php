<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $users = User::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('User/Index', [
            'users' => $users,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function details(User $user): Response
    {
        return Inertia::render('User/Details', [
            'user' => $user,
            'user_roles' => $user->roles,
            'user_permissions' => $user->permissions,
            'permissions' => Permission::all(['id', 'name', 'guard_name']),
            'roles' => Role::all(['id', 'name', 'guard_name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        return Redirect::route('users.details', [
            'user' => $user->id
        ])->with('message', 'user-created');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('User/Details', [
            'user' => null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return Redirect::route('users.details', [
            'user' => $user->id
        ])->with('message', 'role-updated');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::route('roles.index')
            ->with('message', "$user->name is deleted");
    }
}

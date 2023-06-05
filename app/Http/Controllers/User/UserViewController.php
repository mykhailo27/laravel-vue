<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
    public function index(): Response
    {
        return Inertia::render('User/Index', [
            'users' => User::paginate(10)
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
        ])->with('message', 'agency-updated');
    }
}

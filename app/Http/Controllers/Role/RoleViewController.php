<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Permission;
use App\Models\Role;

class RoleViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $roles = Role::query()
            ->when($request->get('search'), static function (Builder $query, string $search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('guard_name', 'like', "%$search%");
            })
            ->paginate($request->get('per_page', 10))
            ->through(fn($role) => [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'created_at' => $role->created_at,
            ])
            ->withQueryString()
            ->onEachSide(0);

        return Inertia::render('Role/Index', [
            'roles' => $roles,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());

        return Redirect::route('roles.details', [
            'role' => $role->id
        ])->with('message', 'role-created');
    }

    /**
     * Display the specified resource.
     */
    public function create(): Response
    {
        return Inertia::render('Role/Details', [
            'role' => null,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function details(Role $role): Response
    {
        return Inertia::render('Role/Details', [
            'role' => $role,
            'role_permissions' => $role->permissions,
            'permissions' => Permission::all(['id', 'name', 'guard_name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return Redirect::route('roles.details', [
            'role' => $role->id
        ])->with('message', 'role-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return Redirect::route('roles.index')
            ->with('message', "$role->name is deleted");
    }
}

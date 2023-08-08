<?php

namespace App\Policies;

use App\Constants\Permission;
use App\Constants\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
{
    public function __construct(private readonly string $model_name)
    {
    }

    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole(Role::ADMIN)) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permission::VIEW_ANY . $this->model_name);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Model $model): bool
    {
        return $user->hasPermissionTo(Permission::VIEW . $this->model_name);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permission::CREATE . $this->model_name);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Model $model): bool
    {
        return $user->hasPermissionTo(Permission::UPDATE . $this->model_name);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $model): bool
    {
        return $user->hasPermissionTo(Permission::DELETE . $this->model_name);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Model $model): bool
    {
        return $user->hasPermissionTo(Permission::RESTORE . $this->model_name);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Model $model): bool
    {
        return $user->hasPermissionTo(Permission::FORCE_DELETE . $this->model_name);
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo(Permission::DELETE_ANY . $this->model_name);
    }
}

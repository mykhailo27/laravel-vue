<?php

namespace App\Policies;

use App\Constants\Permission;
use App\Constants\Role;
use App\Models\Agency;
use App\Models\User;

class AgencyPolicy
{
    private string $model = 'agency';

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
        return $user->hasPermissionTo(Permission::VIEW_ANY . $this->model);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Permission::VIEW . $this->model);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permission::CREATE . $this->model);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Permission::UPDATE . $this->model);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Permission::DELETE . $this->model);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Permission::RESTORE . $this->model);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Permission::FORCE_DELETE . $this->model);
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo(Permission::DELETE_ANY . $this->model);
    }
}

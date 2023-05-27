<?php

namespace App\Policies;

use App\Constants\Right;
use App\Models\Agency;
use App\Models\User;

class AgencyPolicy
{
    private string $model = 'agency';

    public function before(User $user, string $ability): bool|null
    {
        // todo check if user is agency user
        // todo check if user has role of full admin
        // todo check if user has all the permissions

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Right::VIEW_ANY . $this->model);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Right::VIEW . $this->model);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Right::CREATE . $this->model);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Right::UPDATE . $this->model);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Right::DELETE . $this->model);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Right::RESTORE . $this->model);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Agency $agency): bool
    {
        return $user->hasPermissionTo(Right::FORCE_DELETE . $this->model);
    }
}

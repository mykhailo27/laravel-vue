<?php

namespace App\Policies;

use App\Constants\Permission;
use App\Constants\PermissionModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::USER);
    }

    public function delete(User $user, Model $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->hasPermissionTo(Permission::DELETE . $this->model_name);
    }
}

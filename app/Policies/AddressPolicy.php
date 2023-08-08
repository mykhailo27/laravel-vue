<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class AddressPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::ADDRESS);
    }
}

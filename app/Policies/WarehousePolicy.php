<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class WarehousePolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::WAREHOUSE);
    }
}

<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class ProductPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::PRODUCT);
    }
}

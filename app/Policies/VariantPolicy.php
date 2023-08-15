<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class VariantPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::VARIANT);
    }
}

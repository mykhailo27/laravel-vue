<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class CompanyPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::COMPANY);
    }
}

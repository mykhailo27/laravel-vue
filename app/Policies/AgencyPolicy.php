<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class AgencyPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::AGENCY);
    }
}

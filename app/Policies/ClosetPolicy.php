<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class ClosetPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::CLOSET);
    }
}

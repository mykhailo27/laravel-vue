<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class PackagePolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::PACKAGE);
    }
}

<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class ShipmentPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::SHIPMENT);
    }
}

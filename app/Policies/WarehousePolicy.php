<?php

namespace App\Policies;

class WarehousePolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct('warehouse');
    }
}

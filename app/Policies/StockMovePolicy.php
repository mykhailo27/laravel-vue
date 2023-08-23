<?php

namespace App\Policies;

use App\Constants\PermissionModel;

class StockMovePolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct(PermissionModel::STOCK_MOVE);
    }
}

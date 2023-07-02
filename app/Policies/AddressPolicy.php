<?php

namespace App\Policies;

class AddressPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct('address');
    }
}

<?php

namespace App\Policies;

class AgencyPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct('agency');
    }
}

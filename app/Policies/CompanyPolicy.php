<?php

namespace App\Policies;

class CompanyPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct('company');
    }
}

<?php

namespace App\Policies;

class CountryPolicy extends BasePolicy
{
    public function __construct()
    {
        parent::__construct('country');
    }
}

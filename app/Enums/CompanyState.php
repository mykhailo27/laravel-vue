<?php

namespace App\Enums;

enum CompanyState: string
{
    use Enumeration;

    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}

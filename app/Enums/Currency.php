<?php

namespace App\Enums;

enum Currency: string
{
    use Enumeration;

    case USD = '$';
    case EUR = '€';
    case GBP = '£';
}

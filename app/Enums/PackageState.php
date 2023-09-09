<?php

namespace App\Enums;

enum PackageState: string
{
    use Enumeration;

    case STOCKED = 'stocked';
    case UNSTOCKED = 'unstocked';
    case PARTIALLY = 'partially';
}


<?php

namespace App\Enums;

enum SizeEnum: string
{
    use Enumeration;

    case LARGE = 'L';
    case MEDIUM = 'M';
    case SMALL = 'S';
}

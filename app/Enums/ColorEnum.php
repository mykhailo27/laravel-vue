<?php

namespace App\Enums;

enum ColorEnum: string
{
    use Enumeration;

    case RED = '#FF0000';
    case WHITE = '#FFFFFF';
    case BLACK = '#000000';
}

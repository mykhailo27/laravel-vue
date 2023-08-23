<?php

namespace App\Enums;

enum InventoryType: int
{
    use Enumeration;

    case IN_STOCK = 91;
    case RESERVED = 96;
    case RETURNED = 105;
    case IN_TAKE = 60;
    case LOST = 66;
}

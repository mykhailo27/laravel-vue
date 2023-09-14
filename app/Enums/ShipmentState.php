<?php

namespace App\Enums;

enum ShipmentState: string
{
    use Enumeration;

    case CREATED = 'created';
    case REQUESTED = 'requested';
    case SENT = 'sent';
    case DELIVERED = 'delivered';
    case RECEIVED = 'received';
    case RETURN = 'return';
}

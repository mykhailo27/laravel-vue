<?php

namespace App\Enums;

trait Enumeration
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

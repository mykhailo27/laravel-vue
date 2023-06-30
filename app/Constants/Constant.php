<?php

namespace App\Constants;

use ReflectionClass;

class Constant
{
    public static function getConstants(): array
    {
        return (new ReflectionClass(static::class))
            ->getConstants();
    }
}

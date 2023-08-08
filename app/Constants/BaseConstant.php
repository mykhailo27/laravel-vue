<?php

namespace App\Constants;

use ReflectionClass;

class BaseConstant
{
    public static function getConstants(): array
    {
        return (new ReflectionClass(static::class))
            ->getConstants();
    }
}

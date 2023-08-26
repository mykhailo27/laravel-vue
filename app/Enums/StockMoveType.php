<?php

namespace App\Enums;

enum StockMoveType: int
{
    use Enumeration;

    case INTAKE = 60;
    case SENT = 58;
    case RECEIVED = 71;
    case PROCESSED = 104;

    public static function nextAction(self $type): ?string
    {
        return match ($type) {
            self::INTAKE => 'send',
            self::SENT => 'receive',
            self::RECEIVED => 'process',
            default => null
        };
    }

    public static function previousAction(self $type): ?string
    {
        return match ($type) {
            self::PROCESSED => 'receive',
            self::SENT => 'intake',
            self::RECEIVED => 'send',
            default => null
        };
    }

    public static function getByAction(string $action): StockMoveType
    {
        return match ($action) {
            'receive' => self::RECEIVED,
            'intake' => self::INTAKE,
            'send' => self::SENT,
            'process' => self::PROCESSED
        };
    }
}

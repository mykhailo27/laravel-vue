<?php

namespace App\Enums;

enum StockMoveType: int
{
    use Enumeration;

    case REQUESTED = 114;
    case SENT = 58;
    case RECEIVED = 71;
    case PROCESSED = 104;

    public static function nextAction(self $type): ?string
    {
        return match ($type) {
            self::REQUESTED => 'send',
            self::SENT => 'receive',
            self::RECEIVED => 'process',
            default => null
        };
    }

    public static function previousAction(self $type): ?string
    {
        return match ($type) {
            self::PROCESSED => 'receive',
            self::SENT => 'request',
            self::RECEIVED => 'send',
            default => null
        };
    }

    public static function getByAction(string $action): StockMoveType
    {
        return match ($action) {
            'receive' => self::RECEIVED,
            'request' => self::REQUESTED,
            'send' => self::SENT,
            'process' => self::PROCESSED
        };
    }
}

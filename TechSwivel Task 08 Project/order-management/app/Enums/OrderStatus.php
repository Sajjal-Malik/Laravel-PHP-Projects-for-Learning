<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'PENDING';
    case ACCEPTED = 'ACCEPTED';
    case PICKED = 'PICKED';
    case ON_MY_WAY = 'ON_MY_WAY';
    case DELIVERED = 'DELIVERED';
    case COMPLETED = 'COMPLETED';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

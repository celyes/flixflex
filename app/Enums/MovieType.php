<?php

namespace App\Enums;

enum MovieType: string
{
    case MOVIE = 'movie';
    case SERIES = 'series';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}

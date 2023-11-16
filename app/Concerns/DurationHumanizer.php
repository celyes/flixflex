<?php

namespace App\Concerns;

class DurationHumanizer
{
    public static function inMinutes(int $duration = 0): string
    {
        return $duration / 60 . " minutes";
    }
    public static function inMinutesForHumans(int $duration = 0): string
    {
        $string = "";

        $hours = floor($duration / (60 * 60));
        $minutes = floor($duration % (60 * 60) / 60);
        $seconds = $duration % 60;

        $string .= static::hoursForHumans($hours);
        $string .= static::minutesForHumans($hours, $minutes, $seconds);
        $string .= static::secondsForHumans($seconds);

        return $string;
    }


    protected static function hoursForHumans(int $hours): string
    {
        $string = "";

        if ($hours > 0 && $hours < 2) {
            $string .= "{$hours} hour";
        } elseif ($hours >= 2) {
            $string .= "{$hours} hours";
        }
        return $string;
    }

    protected static function minutesForHumans(int $hours, int $minutes, int $seconds): string
    {
        $string = '';

        if ($minutes > 0) {
            if ($seconds > 0 && $hours > 0) {
                $string .= ", {$minutes} minute";
            } elseif ($seconds > 0 && $hours == 0) {
                $string .= "{$minutes} minute";
            } elseif ($seconds == 0 && $hours > 0) {
                $string .= " and {$minutes} minute";
            } else {
                $string .= "{$minutes} minute";
            }
        }

        if ($minutes > 1) {
            $string .= "s";
        }
        return $string;
    }

    protected static function secondsForHumans(int $seconds): string
    {
        $string = "";
        if ($seconds > 0 && $seconds < 2) {
            $string .= " and {$seconds} second";
        } elseif ($seconds >= 2) {
            $string .= " and {$seconds} seconds";
        }
        return $string;
    }
}

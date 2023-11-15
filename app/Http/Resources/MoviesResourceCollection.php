<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MoviesResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->transform(function ($movie) {
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'poster' => $movie->poster_image_url,
                'genre' => $movie->genre,
                'rating' => $movie->rating,
                'type' => $movie->type,
                'duration' => [
                    'minutes' => $movie->duration / 60,
                    'minutes_readable' => $movie->duration / 60 . " minutes",
                    'minutes_human_readable' => $this->durationForHumans($movie->duration)
                ],
                'released_in' => $movie->released_in
            ];
        })->toArray();
    }

    protected function durationForHumans($duration): string
    {
        $string = "";

        $hours = floor($duration / (60 * 60));
        $minutes = floor($duration % (60 * 60) / 60);
        $seconds = $duration % 60;

        $string .= $this->hoursForHumans($hours);
        $string .= $this->minutesForHumans($hours, $minutes, $seconds);
        $string .= $this->secondsForHumans($seconds);

        return $string;
    }

    protected function hoursForHumans(int $hours): string
    {
        $string = "";
        if ($hours > 0 && $hours < 2) {
            $string .= "{$hours} hour";
        } elseif ($hours >= 2) {
            $string .= "{$hours} hours";
        }
        return $string;
    }

    protected function minutesForHumans(int $hours, int $minutes, int $seconds): string
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

    protected function secondsForHumans(int $seconds): string
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

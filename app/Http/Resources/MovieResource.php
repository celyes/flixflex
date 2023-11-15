<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'poster' => $this->poster_image_url,
            'genre' => $this->genre,
            'languages' => $this->languages,
            'rating' => $this->rating,
            'type' => $this->type,
            'duration' => [
                'minutes' => $this->duration / 60,
                'minutes_readable' => $this->duration / 60 . " minutes",
                'minutes_human_readable' => $this->durationForHumans($this->duration) // 1 hour 1 minute
            ],
            'plot' => $this->plot,
            'released_in' => $this->released_in,
            'trailer' => $this->trailer_url,
        ];
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

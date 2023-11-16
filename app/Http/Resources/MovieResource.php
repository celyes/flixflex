<?php

namespace App\Http\Resources;

use App\Concerns\DurationHumanizer;
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
                'minutes_readable' => DurationHumanizer::inMinutes($this->duration),
                'minutes_human_readable' => DurationHumanizer::inMinutesForHumans($this->duration)
            ],
            'plot' => $this->plot,
            'released_in' => $this->released_in,
            'trailer' => $this->trailer_url,
        ];
    }
}

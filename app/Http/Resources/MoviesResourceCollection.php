<?php

namespace App\Http\Resources;

use App\Concerns\DurationHumanizer;
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
                    'minutes_readable' => DurationHumanizer::inMinutes($movie->duration),
                    'minutes_human_readable' => DurationHumanizer::inMinutesForHumans($movie->duration)
                ],
                'released_in' => $movie->released_in
            ];
        })->toArray();
    }
}

<?php

namespace Database\Seeders;

use App\Enums\MovieType;
use App\Models\Movie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = json_decode(file_get_contents(database_path() . '/datasets/movies.json'), true);
        foreach($movies as $movie) {
            Movie::create($this->transformMovie($movie));
        }
    }

    private function transformMovie($movie): array
    {
        return [
            "title" => $movie['Title'],
            "genre" => $movie['Genre'],
            "plot" => $movie['Plot'],
            "language" => $movie['Language'],
            "country" => $movie['Country'],
            "poster_image_url" => $movie['Poster'],
            "trailer_url" => $movie['Trailer'],
            "duration" => $this->calculateMovieDuration($movie['Runtime']),
            "released_in" => (int) $movie['Year'],
            "rating" => $movie['imdbRating'],
            "type" => MovieType::tryFrom($movie['Type']),
        ];
    }

    protected function calculateMovieDuration(string $durationString): int
    {
        return 60 * explode(' ', $durationString)[0];
    }
}

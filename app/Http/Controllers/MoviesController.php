<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavourizeMovieRequest;
use App\Http\Requests\UnFavourizeMovieRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MoviesResourceCollection;
use App\Http\Resources\MovieTrailerResource;
use App\Models\Movie;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MoviesController extends Controller
{
    /**
     * List movies
     *
     * List all movies.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $per_page = $request->get('per_page', 25);

        $rank_by = $this->getRankingCriteria($request->get('rank_by'));

        return new MoviesResourceCollection(
            Movie::orderBy(...$rank_by)->simplePaginate($per_page)
        );
    }

    public function show(Request $request, Movie $movie): JsonResource
    {
        return new MovieResource($movie);
    }

    public function showTrailer(Request $request, Movie $movie): JsonResource
    {
        return new MovieTrailerResource($movie);
    }

    public function search(Request $request): ResourceCollection
    {
        $query = $request->get('query');

        if (!$query) {
            return $this->index($request);
        }

        $movies = Movie::where('title', 'ILIKE', "%$query%")
            ->orWhere('plot', 'LIKE', "%$query%")
            ->get();
        return new MoviesResourceCollection($movies);
    }

    public function favourites(Request $request)
    {
        $per_page = $request->get('per_page', 25);

        $favouriteMovies = $request->user()->favouriteMovies()->simplePaginate($per_page);

        return new MoviesResourceCollection(
            $favouriteMovies
        );
    }

    public function favourize(FavourizeMovieRequest $request): mixed
    {
        try {
            $request->user()->favouriteMovies()->attach(['movie_id' => $request->movie_id]);
            return $this->success( "Movie added to favourites");
        } catch(UniqueConstraintViolationException) {
            abort(400, "Cannot add movie to favourites");
        }
    }

    public function unfavourize(UnFavourizeMovieRequest $request): JsonResponse
    {
        try {
            $request->user()
                ->favouriteMovies()
                ->detach(['movie_id' => $request->movie_id]);
            return $this->success("movie removed from favourites");
        } catch (UniqueConstraintViolationException) {
            abort(400, "cannot remove movie from favourites list");
        }
    }

    protected function getRankingCriteria(?string $rankingString): array
    {

        $rank_by = $rankingString ? explode(',', $rankingString) : [];

        if (!$rank_by || !in_array($rank_by[0] ?? null, ['released_in', 'rating', 'duration'])) {
            $rank_by[] = 'released_in';
        }

        if (!$rank_by || !in_array($rank_by[1] ?? null, ['asc', 'desc'])) {
            $rank_by[] = 'desc';
        }

        return $rank_by;
    }


}

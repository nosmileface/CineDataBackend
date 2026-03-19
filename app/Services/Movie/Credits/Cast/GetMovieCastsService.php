<?php

namespace App\Services\Movie\Credits\Cast;

use App\Models\Movie\Movie;
use App\Repositories\Movie\Credits\Cast\MovieCastRepository;
use App\Repositories\Movie\MovieRepository;
use App\Services\TMDBClientService;

class GetMovieCastsService
{
    private const string MOVIE_CASTS_KEY = 'cast';

    public function __construct
    (
        private TMDBClientService   $TMDBClientService,
        private MovieRepository     $movieRepository,
        private MovieCastRepository $movieCastRepository
    ){}

    public function syncMovieCasts(Movie $movie): int
    {
        $ids = [];

        $imported = 0;

        $movieCasts = $this->getMovieCasts(movieId: $movie->tmdb_id);

        foreach ($movieCasts[self::MOVIE_CASTS_KEY] as $movieCast)
        {
            if (empty($movieCast))
            {
                continue;
            }

            $data = $this->movieCastRepository->updateOrCreate(data: $movieCast);

            $ids[$data['id']] = ['character' => $movieCast['character']];

            $imported++;
        }

        if ($ids)
        {
            $this->movieRepository->attachMovieCasts
            (
                movie: $movie,
                ids: $ids
            );
        }

        return $imported;
    }

    private function getMovieCasts(int $movieId): array
    {
        return $this->TMDBClientService->fetchMovieCredits(movieId: $movieId);
    }
}
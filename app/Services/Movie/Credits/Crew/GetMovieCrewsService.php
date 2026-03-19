<?php

namespace App\Services\Movie\Credits\Crew;

use App\Models\Movie\Movie;
use App\Repositories\Movie\Credits\Crew\MovieCrewRepository;
use App\Repositories\Movie\MovieRepository;
use App\Services\TMDBClientService;

class GetMovieCrewsService
{
    private const string MOVIE_CREWS_KEY = 'crew';

    public function __construct
    (
        private TMDBClientService $TMDBClientService,
        private MovieRepository $movieRepository,
        private MovieCrewRepository $movieCrewRepository
    ){}

    public function syncMovieCrews(Movie $movie): int
    {
        $ids = [];

        $imported = 0;

        $movieCrews = $this->getMovieCrews(movieId: $movie->tmdb_id);

        if (empty($movieCrews[self::MOVIE_CREWS_KEY]))
        {
            return 0;
        }

        foreach ($movieCrews[self::MOVIE_CREWS_KEY] as $movieCrew)
        {
            $data = $this->movieCrewRepository->updateOrCreate(data: $movieCrew);

            $ids[$data['id']] = ['department' => $movieCrew['department']];

            $imported++;
        }

        if ($ids)
        {
            $this->movieRepository->attachMovieCrews
            (
                movie: $movie,
                ids: $ids
            );
        }

        return $imported;
    }

    private function getMovieCrews(int $movieId): array
    {
        return $this->TMDBClientService->fetchMovieCredits(movieId: $movieId);
    }
}
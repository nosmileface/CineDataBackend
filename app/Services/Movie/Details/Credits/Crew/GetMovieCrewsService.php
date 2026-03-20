<?php

namespace App\Services\Movie\Details\Credits\Crew;

use App\Models\Movie\Movie;
use App\Repositories\Movie\Credits\Crew\MovieCrewRepository;
use App\Repositories\Movie\MovieRepository;
use App\Services\TMDBClientService;

class GetMovieCrewsService
{
    private const string RESPONSE_KEY_CREWS = 'crew';

    public function __construct
    (
        private TMDBClientService   $TMDBClientService,
        private MovieRepository     $movieRepository,
        private MovieCrewRepository $movieCrewRepository
    ){}

    public function syncMovieCrews(Movie $movie): int
    {
        $ids = [];

        $imported = 0;

        $movieCrews = $this->getMovieCrews(movieId: $movie->tmdb_id);

        foreach ($movieCrews[self::RESPONSE_KEY_CREWS] as $movieCrew)
        {
            if (empty($movieCrew))
            {
                continue;
            }

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
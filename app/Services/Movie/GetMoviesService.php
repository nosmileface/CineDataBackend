<?php

namespace App\Services\Movie;

use App\Models\Movie\Genre\MovieGenre;
use App\Repositories\Movie\Genre\MovieGenresRepository;
use App\Repositories\Movie\MovieRepository;
use App\Services\TMDBClientService;

class GetMoviesService
{
    private const string MOVIES_KEY = 'results';

    public function __construct
    (
        private TMDBClientService $TMDBClientService,
        private MovieGenresRepository $movieGenresRepository,
        private MovieRepository $movieRepository
    ){}

    public function syncMovies(MovieGenre $movieGenre, int $limit): int
    {
        $ids = [];

        $page = 1;

        $imported = 0;

        do
        {
            $movies = $this->getMovies
            (
                genreId: $movieGenre->tmdb_id,
                page: $page
            );

            if (empty($movies[self::MOVIES_KEY]))
            {
                break;
            }

            foreach ($movies[self::MOVIES_KEY] as $movie)
            {
                if ($imported >= $limit)
                {
                    break 2;
                }

                $data = $this->movieRepository->updateOrCreate(data: $movie);

                $ids[] = $data['id'];

                $imported++;
            }

            $page++;

        } while ($imported <= $limit);

        if ($ids)
        {
            $this->movieGenresRepository->attachMovies
            (
                movieGenre: $movieGenre,
                ids: $ids
            );
        }

        return $imported;
    }

    private function getMovies(int $genreId, int $page): array
    {
        return $this->TMDBClientService->fetchMovies
        (
            genreId: $genreId,
            page: $page
        );
    }
}
<?php

namespace App\Services\Movie;

use App\Models\Movie\Genre\MovieGenre;
use App\Repositories\Movie\Genre\MovieGenreRepository;
use App\Repositories\Movie\MovieRepository;
use App\Services\TMDBClientService;

class GetMoviesService
{
    private const string MOVIES_KEY = 'results';

    public function __construct
    (
        private TMDBClientService       $TMDBClientService,
        private MovieGenreRepository    $movieGenresRepository,
        private MovieRepository         $movieRepository
    ){}

    public function syncMovies(MovieGenre $movieGenre, int $limit): array
    {
        $ids = [];

        $syncMovies = [];

        $page = 1;

        do
        {
            $movies = $this->getMovies
            (
                movieGenreId: $movieGenre->tmdb_id,
                page: $page
            );

            if (empty($movies[self::MOVIES_KEY]))
            {
                break;
            }

            foreach ($movies[self::MOVIES_KEY] as $movie)
            {
                if (count($ids) >= $limit)
                {
                    break 2;
                }

                $data = $this->movieRepository->updateOrCreate(data: $movie);

                $ids[] = $data['id'];

                $syncMovies[] = $data;
            }

            $page++;

        } while (true);

        if ($ids)
        {
            $this->movieGenresRepository->attachMovies
            (
                movieGenre: $movieGenre,
                ids: $ids
            );
        }

        return $syncMovies;
    }

    private function getMovies(int $movieGenreId, int $page): array
    {
        return $this->TMDBClientService->fetchMovies
        (
            movieGenreId: $movieGenreId,
            page: $page
        );
    }
}
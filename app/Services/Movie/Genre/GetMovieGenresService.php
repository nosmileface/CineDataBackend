<?php

namespace App\Services\Movie\Genre;

use App\Repositories\Movie\Genre\MovieGenreRepository;
use App\Services\TMDBClientService;

class GetMovieGenresService
{
    private const string MOVIE_GENRES_KEY = 'genres';

    public function __construct
    (
        private TMDBClientService       $TMDBClientService,
        private MovieGenreRepository    $movieGenresRepository
    ){}

    public function syncGenres(): int
    {
        $imported = 0;

        $genres = $this->getMovieGenres();

        if (empty($genres[self::MOVIE_GENRES_KEY]))
        {
            return 0;
        }

        foreach ($genres[self::MOVIE_GENRES_KEY] as $genre)
        {
            $this->movieGenresRepository->updateOrCreate(data: $genre);

            $imported++;
        }

        return $imported;
    }

    private function getMovieGenres(): array
    {
        return $this->TMDBClientService->fetchGenres();
    }
}
<?php

namespace App\Services\Movie\Details\Genre;

use App\Repositories\Movie\Genre\MovieGenreRepository;
use App\Services\TMDBClientService;

class GetMovieGenresService
{
    private const string RESPONSE_KEY_GENRES = 'genres';

    public function __construct
    (
        private TMDBClientService       $TMDBClientService,
        private MovieGenreRepository    $movieGenresRepository
    ){}

    public function syncGenres(): array
    {
        $syncMovieGenres = [];

        $movieGenres = $this->getMovieGenres();

        if (empty($movieGenres[self::RESPONSE_KEY_GENRES]))
        {
            return [];
        }

        foreach ($movieGenres[self::RESPONSE_KEY_GENRES] as $movieGenre)
        {
            $data = $this->movieGenresRepository->updateOrCreate(data: $movieGenre);

            $syncMovieGenres[] = $data;
        }

        return $syncMovieGenres;
    }

    private function getMovieGenres(): array
    {
        return $this->TMDBClientService->fetchGenres();
    }
}
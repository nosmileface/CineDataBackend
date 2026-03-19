<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TMDBClientService
{
    private const string GENRES_ENDPOINT = '/3/genre/movie/list';

    public function fetchGenres(): array
    {
        return $this->fetch(endpoint: self::GENRES_ENDPOINT, params:
            [
               'api_key' => config('tmdb.TMDB_API_KEY'),
               'language' => 'ru'
            ]
        );

    }

    public function fetch(string $endpoint, array $params = []): array
    {
        $response = Http::get(config('tmdb.TMDB_API_URL') . $endpoint, $params);

        if (!$response->successful())
        {
            return [];
        }

        return $response->json();
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TMDBClientService
{
    private const string MOVIE_GENRES_ENDPOINT = '/3/genre/movie/list';
    private const string MOVIES_ENDPOINT = '/3/discover/movie';
    private const string MOVIE_CASTS_ENDPOINT = '/3/movie/%d/credits';
    private const string MOVIE_IMAGES_ENDPOINT = '/3/movie/%d/images';
    private const string MOVIE_VIDEOS_ENDPOINT = '/3/movie/%d/videos';

    public function fetchMovieVideos(int $movieId): array
    {
        return $this->fetch
        (
            endpoint: sprintf(self::MOVIE_VIDEOS_ENDPOINT, $movieId),
            params: ['api_key' => config('tmdb.TMDB_API_KEY')]
        );
    }

    public function fetchMovieImages(int $movieId): array
    {
        return $this->fetch
        (
            endpoint: sprintf(self::MOVIE_IMAGES_ENDPOINT, $movieId),
            params: ['api_key' => config('tmdb.TMDB_API_KEY')]
        );
    }

    public function fetchMovieCredits(int $movieId): array
    {
        return $this->fetch
        (
            endpoint: sprintf(self::MOVIE_CASTS_ENDPOINT, $movieId),
            params: ['api_key' => config('tmdb.TMDB_API_KEY')]
        );
    }

    public function fetchMovies(int $movieGenreId, int $page): array
    {
        return $this->fetch
        (
            endpoint: self::MOVIES_ENDPOINT,
            params:
            [
                'api_key' => config('tmdb.TMDB_API_KEY'),
                'language' => 'ru',
                'with_genres' => $movieGenreId,
                'page' => $page
            ]
        );
    }

    public function fetchGenres(): array
    {
        return $this->fetch
        (
            endpoint: self::MOVIE_GENRES_ENDPOINT,
            params:
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
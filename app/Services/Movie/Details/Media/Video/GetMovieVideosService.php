<?php

namespace App\Services\Movie\Details\Media\Video;

use App\Models\Movie\Movie;
use App\Repositories\Movie\Media\Video\MovieVideoRepository;
use App\Services\TMDBClientService;

class GetMovieVideosService
{
    private const string MOVIE_VIDEOS_KEY = 'results';

    public function __construct
    (
        private TMDBClientService       $TMDBClientService,
        private MovieVideoRepository    $movieVideoRepository
    ){}

    public function syncMovieVideos(Movie $movie): int
    {
        $imported = 0;

        $movieVideos = $this->getMovieVideos(movieId: $movie->tmdb_id);

        foreach ($movieVideos[self::MOVIE_VIDEOS_KEY] as $movieVideo)
        {
            if (empty($movieVideo))
            {
                continue;
            }

            $this->movieVideoRepository->updateOrCreate
            (
                movieId: $movie->id,
                data: $movieVideo
            );

            $imported++;
        }

        return $imported;
    }

    private function getMovieVideos(int $movieId): array
    {
        return $this->TMDBClientService->fetchMovieVideos(movieId: $movieId);
    }
}
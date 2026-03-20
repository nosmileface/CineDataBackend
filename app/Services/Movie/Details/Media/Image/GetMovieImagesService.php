<?php

namespace App\Services\Movie\Details\Media\Image;

use App\Models\Movie\Movie;
use App\Repositories\Movie\Media\Image\MovieImageRepository;
use App\Repositories\Movie\Media\Image\Type\MovieImageTypeRepository;
use App\Services\TMDBClientService;

class GetMovieImagesService
{
    private const array RESPONSE_KEY_IMAGES =
        [
            'backdrops' => 'backdrop',
            'logos' => 'logo',
            'posters' => 'poster'
        ];

    public function __construct
    (
        private TMDBClientService           $TMDBClientService,
        private MovieImageTypeRepository    $movieImageTypeRepository,
        private MovieImageRepository        $movieImageRepository
    ){}

    public function syncMovieImages(Movie $movie): int
    {
        $imported = 0;

        $movieImages = $this->getMovieImages(movieId: $movie->tmdb_id);

        foreach (self::RESPONSE_KEY_IMAGES as $key => $value)
        {
            if (empty($movieImages[$key]))
            {
                continue;
            }

            $movieImageTypeId = $this->movieImageTypeRepository->findIdByType(type: $value);

            foreach ($movieImages[$key] as $movieImage)
            {
                $this->movieImageRepository->updateOrCreate
                (
                    movieId: $movie->id,
                    movieImageTypeId: $movieImageTypeId,
                    data: $movieImage
                );

                $imported++;
            }
        }

        return $imported;
    }

    private function getMovieImages(int $movieId): array
    {
        return $this->TMDBClientService->fetchMovieImages(movieId: $movieId);
    }
}
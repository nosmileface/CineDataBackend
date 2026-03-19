<?php

namespace App\Repositories\Movie\Media\Image;

use App\Models\Movie\Media\Image\MovieImage;

class MovieImageRepository
{
    public function __construct(private MovieImage $movieImage){}

    public function updateOrCreate(int $movieId, int $movieImageTypeId, array $data): MovieImage
    {
        return $this->movieImage->query()->updateOrCreate
        (
            [
                'movie_id' => $movieId,
                'file_path' => $data['file_path']
            ],
            [
                'movie_id' => $movieId,
                'movie_image_type_id' => $movieImageTypeId,
                'width' => $data['width'],
                'height' => $data['height'],
                'file_path' => $data['file_path']
            ]
        );
    }
}
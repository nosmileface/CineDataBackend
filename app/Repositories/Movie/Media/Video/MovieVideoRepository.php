<?php

namespace App\Repositories\Movie\Media\Video;

use App\Models\Movie\Media\Video\MovieVideo;

class MovieVideoRepository
{
    public function __construct(private MovieVideo $movieVideo){}

    public function updateOrCreate(int $movieId, array $data): MovieVideo
    {
        return $this->movieVideo->query()->updateOrCreate
        (
            [
                'tmdb_id' => $data['id']
            ],
            [
                'movie_id' => $movieId,
                'key' => $data['key'],
                'name' => $data['name'],
                'site' => $data['site'],
                'size' => $data['size'],
                'published_at' => $data['published_at']
            ]
        );
    }
}
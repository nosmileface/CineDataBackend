<?php

namespace App\Repositories\Movie;

use App\Models\Movie\Movie;

class MovieRepository
{
    public function __construct(private Movie $movie){}

    public function updateOrCreate(array $data): Movie
    {
        return $this->movie->query()->updateOrCreate
        (
            [
                'tmdb_id' => $data['id']
            ],
            [
                'title' => mb_ucfirst($data['title']),
                'original_title' => $data['original_title'],
                'original_language' => $data['original_language'],
                'overview' => $data['overview'],
                'popularity' => $data['popularity'],
                'poster_path' => $data['poster_path'],
                'release_date' => $data['release_date']
            ]
        );
    }
}
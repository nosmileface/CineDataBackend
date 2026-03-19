<?php

namespace App\Repositories\Movie\Credits\Cast;

use App\Models\Movie\Cast\MovieCast;

class MovieCastRepository
{
    public function __construct(private MovieCast $movieCast){}

    public function updateOrCreate(array $data): MovieCast
    {
        return $this->movieCast->query()->updateOrCreate
        (
            [
                'tmdb_id' => $data['id']
            ],
            [
                'name' => $data['name'],
                'original_name' => $data['original_name'],
                'popularity' => $data['popularity'],
                'profile_path' => $data['profile_path']
            ]
        );
    }
}
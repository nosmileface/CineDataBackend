<?php

namespace App\Repositories\Movie\Credits\Crew;

use App\Models\Movie\Credits\Crew\MovieCrew;

class MovieCrewRepository
{
    public function __construct(private MovieCrew $movieCrew){}

    public function updateOrCreate(array $data): MovieCrew
    {
        return $this->movieCrew->query()->updateOrCreate
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
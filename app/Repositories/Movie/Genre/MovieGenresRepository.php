<?php

namespace App\Repositories\Movie\Genre;

use App\Models\Movie\Genre\MovieGenre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class MovieGenresRepository
{
    public function __construct(private MovieGenre $movieGenre){}

    public function getAll(): Collection
    {
        return $this->movieGenre->query()->get();
    }

    public function updateOrCreate(array $data): MovieGenre
    {
        return $this->movieGenre->query()->updateOrCreate
        (
            [
                'tmdb_id' => $data['id']
            ],
            [
                'name' => mb_ucfirst($data['name']),
                'slug' => ucfirst(Str::slug($data['name']))
            ]
        );
    }

    public function attachMovies(MovieGenre $movieGenre, array $ids): void
    {
        $movieGenre->movies()->syncWithoutDetaching($ids);
    }
}
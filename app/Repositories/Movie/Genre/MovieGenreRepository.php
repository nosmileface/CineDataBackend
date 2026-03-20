<?php

namespace App\Repositories\Movie\Genre;

use App\Constants\Query;
use App\Models\Movie\Genre\MovieGenre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class MovieGenreRepository
{
    public function __construct(private MovieGenre $movieGenre){}

    public function getAll(): Collection
    {
        return $this->movieGenre->query()->get();
    }

    public function getAllWithPagination(array $filters): LengthAwarePaginator
    {
        return $this->movieGenre->query()
            ->orderBy(Query::COLUMN_ID, Query::SORT_DESC)
            ->paginate($filters['perPage'] ?? Query::PER_PAGE);
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
<?php

namespace App\Repositories\Movie;

use App\Constants\Query;
use App\Models\Movie\Movie;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepository
{
    private const array RELATIONS =
        [
            'movieGenres',
            'movieActors',
            'movieCrews',
            'movieImages',
            'movieImages.type',
            'movieVideos'
        ];

    public function __construct(private Movie $movie){}

    public function getAllWithPagination(array $filters): LengthAwarePaginator
    {
        return $this->movie->query()
            ->orderBy(Query::COLUMN_ID, Query::SORT_DESC)
            ->paginate($filters['perPage'] ?? Query::PER_PAGE);
    }

    public function find(Movie $movie): Movie
    {
        return $this->movie->query()->with(self::RELATIONS)->findOrFail($movie->id);
    }

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

    public function attachMovieCasts(Movie $movie, array $ids): void
    {
        $movie->movieActors()->syncWithoutDetaching($ids);
    }

    public function attachMovieCrews(Movie $movie, array $ids): void
    {
        $movie->movieCrews()->syncWithoutDetaching($ids);
    }
}
<?php

namespace App\Models\Movie;

use App\Models\Movie\Genre\MovieGenre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    protected $fillable =
        [
            'tmdb_id',
            'title',
            'original_title',
            'original_language',
            'overview',
            'popularity',
            'poster_path',
            'release_date'
        ];

    // Relations
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(MovieGenre::class, 'genre_movie', 'movie_id', 'genre_id');
    }
}

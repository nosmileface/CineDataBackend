<?php

namespace App\Models\Movie\Genre;

use App\Models\Movie\Movie;
use App\Traits\Movie\Genre\MovieGenreSort;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MovieGenre extends Model
{
    use MovieGenreSort;

    protected $fillable = ['tmdb_id', 'name', 'slug'];

    // Relations
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'genre_movie', 'genre_id', 'movie_id');
    }
}

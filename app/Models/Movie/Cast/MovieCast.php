<?php

namespace App\Models\Movie\Cast;

use App\Models\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MovieCast extends Model
{
    protected $fillable =
        [
            'tmdb_id',
            'name',
            'original_name',
            'popularity',
            'profile_path'
        ];

    // Relations
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'cast_movie', 'cast_id', 'movie_id')
            ->withPivot('character');
    }
}

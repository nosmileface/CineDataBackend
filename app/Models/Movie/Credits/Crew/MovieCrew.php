<?php

namespace App\Models\Movie\Credits\Crew;

use App\Models\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MovieCrew extends Model
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
        return $this->belongsToMany(Movie::class, 'crew_movie', 'crew_id', 'movie_id')
            ->withPivot('department');
    }
}

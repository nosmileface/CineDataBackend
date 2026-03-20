<?php

namespace App\Models\Movie;

use App\Models\Movie\Credits\Cast\MovieCast;
use App\Models\Movie\Credits\Crew\MovieCrew;
use App\Models\Movie\Genre\MovieGenre;
use App\Models\Movie\Media\Image\MovieImage;
use App\Models\Movie\Media\Video\MovieVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function movieGenres(): BelongsToMany
    {
        return $this->belongsToMany(MovieGenre::class, 'genre_movie', 'movie_id', 'genre_id');
    }

    public function movieActors(): BelongsToMany
    {
        return $this->belongsToMany(MovieCast::class, 'cast_movie', 'movie_id', 'cast_id')
            ->withPivot('character');
    }

    public function movieCrews(): BelongsToMany
    {
        return $this->belongsToMany(MovieCrew::class, 'crew_movie', 'movie_id', 'crew_id')
            ->withPivot('department');
    }

    public function movieImages(): HasMany
    {
        return $this->hasMany(MovieImage::class);
    }

    public function movieVideos(): HasMany
    {
        return $this->hasMany(MovieVideo::class);
    }
}

<?php

namespace App\Models\Movie\Media\Video;

use App\Models\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieVideo extends Model
{
    protected $fillable =
        [
            'movie_id',
            'tmdb_id',
            'key',
            'name',
            'site',
            'size',
            'published_at'
        ];

    // Relations
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}

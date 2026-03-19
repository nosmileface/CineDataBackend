<?php

namespace App\Models\Movie\Media\Image;

use App\Models\Movie\Media\Image\Type\MovieImageType;
use App\Models\Movie\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieImage extends Model
{
    protected $fillable =
        [
            'movie_id',
            'movie_image_type_id',
            'width',
            'height',
            'file_path'
        ];

    // Relations

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MovieImageType::class);
    }
}

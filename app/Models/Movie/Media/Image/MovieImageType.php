<?php

namespace App\Models\Movie\Media\Image;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MovieImageType extends Model
{
    protected $fillable = ['name', 'type'];

    // Relations
    public function images(): HasMany
    {
        return $this->hasMany(MovieImage::class);
    }
}

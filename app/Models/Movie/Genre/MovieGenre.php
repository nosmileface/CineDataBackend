<?php

namespace App\Models\Movie\Genre;

use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    protected $fillable = ['tmdb_id', 'name', 'slug'];
}

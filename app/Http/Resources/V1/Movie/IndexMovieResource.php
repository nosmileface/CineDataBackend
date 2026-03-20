<?php

namespace App\Http\Resources\V1\Movie;

use App\Http\Resources\V1\Movie\Genre\IndexMovieGenreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexMovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tmdb_id' => $this->tmdb_id,
            'title' => $this->title,
            'original_title' => $this->original_title,
            'original_language' => $this->original_language,
            'overview' => $this->overview,
            'popularity' => $this->popularity,
            'poster_path' => $this->poster_path,
            'release_date' => $this->release_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'movieGenres' => IndexMovieGenreResource::collection($this->movieGenres)
        ];
    }
}

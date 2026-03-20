<?php

namespace App\Http\Resources\V1\Movie\Media\Video;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexMovieVideoResource extends JsonResource
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
            'key' => $this->key,
            'name' => $this->name,
            'site' => $this->site,
            'size' => $this->size,
            'published_at' => Carbon::parse($this->published_at)->format('Y-m-d'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

<?php

namespace App\Http\Resources\V1\Movie\Credits\Cast;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexMovieCastResource extends JsonResource
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
            'name' => $this->name,
            'original_name' => $this->original_name,
            'character' => $this->pivot->character,
            'popularity' => $this->popularity,
            'profile_path' => $this->profile_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

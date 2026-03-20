<?php

namespace App\Http\Resources\V1\Movie\Media\Image;

use App\Http\Resources\V1\Movie\Media\Image\Type\IndexMovieImageTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexMovieImageResource extends JsonResource
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
            'movie_image_type_id' => $this->movie_image_type_id,
            'width' => $this->width,
            'height' => $this->height,
            'file_path' => $this->file_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'movieImageType' => IndexMovieImageTypeResource::make($this->type)
        ];
    }
}

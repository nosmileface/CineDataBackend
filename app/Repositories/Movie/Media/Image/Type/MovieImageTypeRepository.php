<?php

namespace App\Repositories\Movie\Media\Image\Type;

use App\Models\Movie\Media\Image\Type\MovieImageType;

class MovieImageTypeRepository
{
    public function __construct(private MovieImageType $movieImageType){}

    public function findIdByType(string $type): int
    {
        return $this->movieImageType->query()->where('type', $type)->value('id');
    }
}
<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Controller;
use App\Services\Movie\Genre\GetMovieGenresService;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    public function __construct
    (
        private GetMovieGenresService $getMovieGenresService
    )
    {}

    public function GetGenres(): JsonResponse
    {
        $genres = $this->getMovieGenresService->syncGenres();

        return response()->json
        (
            [
                'message' => 'Жанры фильмов получены. Количество: ' . $genres . '.',
                'code' => JsonResponse::HTTP_CREATED
            ]
        );
    }
}

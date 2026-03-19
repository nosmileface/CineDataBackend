<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Controller;
use App\Models\Movie\Genre\MovieGenre;
use App\Models\Movie\Movie;
use App\Services\Movie\Cast\GetMovieCastsService;
use App\Services\Movie\Genre\GetMovieGenresService;
use App\Services\Movie\GetMoviesService;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    public function __construct
    (
        private GetMovieGenresService $getMovieGenresService,
        private GetMoviesService $getMoviesService,
        private GetMovieCastsService $getMovieCastsService
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

    public function GetMovies(MovieGenre $movieGenre): JsonResponse
    {
        $movies = $this->getMoviesService->syncMovies
        (
            movieGenre: $movieGenre,
            limit: 10
        );

        return response()->json
        (
            [
                'message' => 'Фильмы для конкретного жанра получены. Количество: ' . $movies . '.',
                'code' => JsonResponse::HTTP_CREATED
            ]
        );
    }

    public function GetMovieCasts(Movie $movie): JsonResponse
    {
        $movieCasts = $this->getMovieCastsService->syncMovieCasts(movie: $movie);

        return response()->json
        (
            [
                'message' => 'Актеры для конкретного фильма получены. Количество: ' . $movieCasts . '.',
                'code' => JsonResponse::HTTP_CREATED
            ]
        );
    }
}

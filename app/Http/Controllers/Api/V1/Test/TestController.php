<?php

namespace App\Http\Controllers\Api\V1\Test;

use App\Http\Controllers\Controller;
use App\Models\Movie\Genre\MovieGenre;
use App\Models\Movie\Movie;
use App\Services\Movie\Details\Credits\Cast\GetMovieCastsService;
use App\Services\Movie\Details\Credits\Crew\GetMovieCrewsService;
use App\Services\Movie\Details\Genre\GetMovieGenresService;
use App\Services\Movie\Details\Media\Image\GetMovieImagesService;
use App\Services\Movie\Details\Media\Video\GetMovieVideosService;
use App\Services\Movie\GetMoviesService;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    private const int MOVIES_LIMIT_FOR_GENRE = 10;

    public function __construct
    (
        private GetMovieGenresService   $getMovieGenresService,
        private GetMoviesService        $getMoviesService,
        private GetMovieCastsService    $getMovieCastsService,
        private GetMovieCrewsService    $getMovieCrewsService,
        private GetMovieImagesService   $getMovieImagesService,
        private GetMovieVideosService   $getMovieVideosService
    )
    {}

    public function GetGenres(): JsonResponse
    {
        $genres = $this->getMovieGenresService->syncGenres();

        return response()->json
        (
            [
                'message' => 'Жанры фильмов получены. Количество: ' . count($genres) . ' жанров.',
                'code' => JsonResponse::HTTP_CREATED
            ]
        );
    }

    public function GetMovies(MovieGenre $movieGenre): JsonResponse
    {
        $movies = $this->getMoviesService->syncMovies
        (
            movieGenre: $movieGenre,
            limit: self::MOVIES_LIMIT_FOR_GENRE
        );

        return response()->json
        (
            [
                'message' => 'Фильмы для конкретного жанра получены. Количество: ' . count($movies) . ' фильмов.',
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
                'message' => 'Актеры для конкретного фильма получены. Количество: ' . $movieCasts . ' актеров.',
                'code' => JsonResponse::HTTP_CREATED
            ]
        );
    }

    public function GetMovieCrews(Movie $movie): JsonResponse
    {
        $movieCrews = $this->getMovieCrewsService->syncMovieCrews(movie: $movie);

        return response()->json
        (
            [
                'message' => 'Команды для конкретного фильма получены. Количество: ' . $movieCrews . ' членов команд.',
                'code' => JsonResponse::HTTP_CREATED
            ]
        );
    }

    public function GetMovieImages(Movie $movie): JsonResponse
    {
        $movieImages = $this->getMovieImagesService->syncMovieImages(movie: $movie);

        return response()->json
        (
            [
                'message' => 'Картинки для конкретного фильма получены. Количество: ' . $movieImages . ' картинок.',
                'code' => JsonResponse::HTTP_CREATED
            ]
        );
    }

    public function GetMovieVideos(Movie $movie): JsonResponse
    {
        $movieVideos = $this->getMovieVideosService->syncMovieVideos(movie: $movie);

        return response()->json
        (
            [
                'message' => 'Видео для конкретного фильма получены. Количество: ' . $movieVideos . ' видео.',
                'code' => JsonResponse::HTTP_CREATED
            ]
        );
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

Route::prefix('v1')->group(function () {

    Route::get('movie-genres', [
        V1\Movie\Genre\MovieGenreController::class, 'index'
    ])->name('index.movie.genres');

    Route::apiResource('movies',
        V1\Movie\MovieController::class
    )->only('index', 'show');

    // Test controllers
    Route::prefix('test')->group(function () {

        Route::get('movie-genres', [
            V1\Test\TestController::class, 'GetGenres'
        ])->name('get.movie.genres');

        Route::get('movies/{movieGenre}', [
            V1\Test\TestController::class, 'GetMovies'
        ])->name('get.movies');

        Route::prefix('movies/{movie}')->group(function() {
            Route::get('casts', [
                V1\Test\TestController::class, 'GetMovieCasts'
            ])->name('get.movie.casts');

            Route::get('crews', [
                V1\Test\TestController::class, 'GetMovieCrews'
            ])->name('get.movie.crews');

            Route::get('images', [
                V1\Test\TestController::class, 'GetMovieImages'
            ])->name('get.movie.images');

            Route::get('videos', [
                V1\Test\TestController::class, 'GetMovieVideos'
            ])->name('get.movie.videos');
        });

    });
});

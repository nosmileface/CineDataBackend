<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

Route::prefix('v1')->group(function () {
    Route::prefix('test')->group(function () {

        Route::get('genres', [
            V1\Test\TestController::class, 'GetGenres'
        ])->name('get.movie.genres');

        Route::get('movies/{movieGenre}', [
            V1\Test\TestController::class, 'GetMovies'
        ])->name('get.movies');

        Route::get('movies/{movie}/casts', [
            V1\Test\TestController::class, 'GetMovieCasts'
        ])->name('get.movie.casts');

        Route::get('movies/{movie}/crews', [
            V1\Test\TestController::class, 'GetMovieCrews'
        ])->name('get.movie.crews');

        Route::get('movies/{movie}/images', [
            V1\Test\TestController::class, 'GetMovieImages'
        ])->name('get.movie.images');

        Route::get('movies/{movie}/videos', [
            V1\Test\TestController::class, 'GetMovieVideos'
        ])->name('get.movie.videos');

    });
});

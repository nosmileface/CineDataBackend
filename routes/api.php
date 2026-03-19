<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

Route::prefix('v1')->group(function () {
    Route::prefix('test')->group(function () {
        Route::get('genres', [
            V1\Test\TestController::class, 'GetGenres'
        ])->name('get.movie.genres');
    });
});

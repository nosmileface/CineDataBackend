<?php

namespace App\Jobs;

use App\Models\Movie\Movie;
use App\Services\Movie\Details\Credits\Cast\GetMovieCastsService;
use App\Services\Movie\Details\Credits\Crew\GetMovieCrewsService;
use App\Services\Movie\Details\Media\Image\GetMovieImagesService;
use App\Services\Movie\Details\Media\Video\GetMovieVideosService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SyncMovieDetailsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Movie $movie){}

    /**
     * Execute the job.
     */
    public function handle
    (
        GetMovieCastsService    $getMovieCastsService,
        GetMovieCrewsService    $getMovieCrewsService,
        GetMovieImagesService   $getMovieImagesService,
        GetMovieVideosService   $getMovieVideosService
    ): void
    {
        $movieCasts = $getMovieCastsService->syncMovieCasts(movie: $this->movie);
        $movieCrews = $getMovieCrewsService->syncMovieCrews(movie: $this->movie);
        $movieImages = $getMovieImagesService->syncMovieImages(movie: $this->movie);
        $movieVideos = $getMovieVideosService->syncMovieVideos(movie: $this->movie);

        $this->logFormatted
        (
            movieCasts: $movieCasts,
            movieCrews: $movieCrews,
            movieImages: $movieImages,
            movieVideos: $movieVideos
        );
    }

    private function logFormatted(int $movieCasts, int $movieCrews, int $movieImages, int $movieVideos): void
    {
        $logLabel = '[ID: ' . $this->movie->id . ', Название: ' . $this->movie->title . ']';

        Log::channel('import-movies')->info(
            'Синхронизация завершена для фильма ' . $logLabel . '. ' .
            'Актеры: ' . $movieCasts . ', Команда: ' . $movieCrews .
            ', Картинки: ' . $movieImages . ', Видео: ' . $movieVideos . '.'
        );
    }
}

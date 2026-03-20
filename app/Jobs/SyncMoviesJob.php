<?php

namespace App\Jobs;

use App\Models\Movie\Genre\MovieGenre;
use App\Services\Movie\GetMoviesService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SyncMoviesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct
    (
        private MovieGenre $movieGenre,
        private int $limit
    ){}

    /**
     * Execute the job.
     */
    public function handle(GetMoviesService $getMoviesService): void
    {
        Log::channel('import-movie-genres')->info(
            'Начало синхронизации жанра [ID: ' . $this->movieGenre->id . ', Название: ' . $this->movieGenre->name . ']'
        );

        $movies = $getMoviesService->syncMovies
        (
            movieGenre: $this->movieGenre,
            limit: $this->limit
        );

        foreach ($movies as $movie)
        {
            SyncMovieDetailsJob::dispatch($movie)->onQueue('movies');

            Log::channel('import-movie-genres')->info(
                'Добавлен фильм в очередь [ID: ' . $movie->id . ', Название: ' . $movie->title . '], Жанр: ' . $this->movieGenre->name
            );
        }
    }
}

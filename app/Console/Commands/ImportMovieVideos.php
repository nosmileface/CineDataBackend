<?php

namespace App\Console\Commands;

use App\Repositories\Movie\MovieRepository;
use App\Services\Movie\Media\Video\GetMovieVideosService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('app:import-movie-videos')]
#[Description('Синхронизация видео для каждого фильма.')]
class ImportMovieVideos extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(GetMovieVideosService $getMovieVideosService, MovieRepository $movieRepository): int
    {
        try {
            $count = 0;

            $start = microtime(true);

            $movies = $movieRepository->getAll();

            foreach ($movies as $movie)
            {
                $movieVideo = $getMovieVideosService->syncMovieVideos(movie: $movie);

                $count += $movieVideo;
            }

            $end = microtime(true);

            $this->info('Синхронизация успешна. Получено видео: ' . $count . '. Затрачено времени: ' . $end - $start . ' секунд(ы).');

            return CommandAlias::SUCCESS;

        } catch (\Exception $exception)
        {
            $this->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}

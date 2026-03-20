<?php

namespace App\Console\Commands;

use App\Repositories\Movie\MovieRepository;
use App\Services\Movie\Media\Image\GetMovieImagesService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('app:import-movie-images')]
#[Description('Синхронизация картинок для каждого фильма.')]
class ImportMovieImages extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(GetMovieImagesService $getMovieImagesService, MovieRepository $movieRepository): int
    {
        try {
            $count = 0;

            $start = microtime(true);

            $movies = $movieRepository->getAll();

            foreach ($movies as $movie)
            {
                $movieImage = $getMovieImagesService->syncMovieImages(movie: $movie);

                $count += $movieImage;
            }

            $end = microtime(true);

            $this->info('Синхронизация успешна. Получено картинок: ' . $count . '. Затрачено времени: ' . $end - $start . ' секунд(ы).');

            Log::channel('import-movie-images')->info('Синхронизация успешна. Получено картинок: ' . $count . '. Затрачено времени: ' . $end - $start . ' секунд(ы).');

            return CommandAlias::SUCCESS;

        } catch (\Exception $exception)
        {
            $this->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            Log::channel('import-movie-images')->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}

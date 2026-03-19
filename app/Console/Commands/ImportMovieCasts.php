<?php

namespace App\Console\Commands;

use App\Repositories\Movie\MovieRepository;
use App\Services\Movie\Credits\Cast\GetMovieCastsService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('app:import-movie-casts')]
#[Description('Синхронизация актеров для каждого фильма.')]
class ImportMovieCasts extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(GetMovieCastsService $getMovieCastsService, MovieRepository $movieRepository): int
    {
        try {
            $count = 0;

            $start = microtime(true);

            $movies = $movieRepository->getAll();

            foreach ($movies as $movie)
            {
                $movieCast = $getMovieCastsService->syncMovieCasts(movie: $movie);

                $count += $movieCast;
            }

            $end = microtime(true);

            $this->info('Синхронизация успешна. Получено актеров: ' . $count . '. Затрачено времени: ' . $end - $start . ' секунд(ы).');

            return CommandAlias::SUCCESS;

        } catch (\Exception $exception)
        {
            $this->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}

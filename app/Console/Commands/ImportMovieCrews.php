<?php

namespace App\Console\Commands;

use App\Repositories\Movie\MovieRepository;
use App\Services\Movie\Credits\Crew\GetMovieCrewsService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('app:import-movie-crews')]
#[Description('Синхронизация команды для каждого фильма.')]
class ImportMovieCrews extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(GetMovieCrewsService $getMovieCrewsService, MovieRepository $movieRepository): int
    {
        try {
            $count = 0;

            $start = microtime(true);

            $movies = $movieRepository->getAll();

            foreach ($movies as $movie)
            {
                $movieCrew = $getMovieCrewsService->syncMovieCrews(movie: $movie);

                $count += $movieCrew;
            }

            $end = microtime(true);

            $this->info('Синхронизация успешна. Получено членов команд: ' . $count . '. Затрачено времени: ' . $end - $start . ' секнд(ы).');

            Log::channel('import-movie-crews')->info('Синхронизация успешна. Получено членов команд: ' . $count . '. Затрачено времени: ' . $end - $start . ' секнд(ы).');

            return CommandAlias::SUCCESS;

        } catch (\Exception $exception)
        {
            $this->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            Log::channel('import-movie-crews')->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}

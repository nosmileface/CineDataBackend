<?php

namespace App\Console\Commands;

use App\Repositories\Movie\Genre\MovieGenreRepository;
use App\Services\Movie\GetMoviesService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('app:import-movies')]
#[Description('Синхронизация фильмов для каждого жанра.')]
class ImportMovies extends Command
{
    private const int MOVIES_LIMIT_FOR_GENRE = 10;

    /**
     * Execute the console command.
     */
    public function handle(GetMoviesService $getMoviesService, MovieGenreRepository $movieGenresRepository): int
    {
        try {
            $count = 0;

            $start = microtime(true);

            $genres = $movieGenresRepository->getAll();

            foreach ($genres as $genre)
            {
                $movies = $getMoviesService->syncMovies
                (
                    movieGenre: $genre,
                    limit: self::MOVIES_LIMIT_FOR_GENRE
                );

                $count += $movies;
            }

            $end = microtime(true);

            $this->info('Синхронизация успешна. Получено фильмов: ' . $count . '. Затрачено времени: ' . $end - $start . ' секнд(ы).');

            return CommandAlias::SUCCESS;

        } catch (\Exception $exception)
        {
            $this->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}

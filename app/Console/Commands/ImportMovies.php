<?php

namespace App\Console\Commands;

use App\Jobs\SyncMoviesJob;
use App\Services\Movie\Details\Genre\GetMovieGenresService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('app:import-movies')]
#[Description('Синхронизация фильмов для каждого жанра.')]
class ImportMovies extends Command
{
    private const int MOVIES_LIMIT_FOR_GENRE = 100;

    /**
     * Execute the console command.
     */
    public function handle(GetMovieGenresService $getMovieGenresService): int
    {
        try {
            $movieGenres = $getMovieGenresService->syncGenres();

            foreach ($movieGenres as $movieGenre)
            {
                SyncMoviesJob::dispatch
                (
                    $movieGenre,
                    self::MOVIES_LIMIT_FOR_GENRE
                )->onQueue('genres');
            }

            $this->info('Синхронизация успешна. Получено фильмов: ' . count($movieGenres));

            return CommandAlias::SUCCESS;

        } catch (\Exception $exception)
        {
            $this->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            Log::channel('import-movies')->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}

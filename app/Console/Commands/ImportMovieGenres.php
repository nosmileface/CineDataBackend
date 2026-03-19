<?php

namespace App\Console\Commands;

use App\Services\Movie\Genre\GetMovieGenresService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('app:import-movie-genres')]
#[Description('Синхронизация жанров.')]
class ImportMovieGenres extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(GetMovieGenresService $getMovieGenresService): int
    {
        try {
            $start = microtime(true);

            $genres = $getMovieGenresService->syncGenres();

            $end = microtime(true);

            $this->info('Синхронизация успешна. Жанров получено: ' . $genres. '. Затрачено времени: ' . $end - $start .  ' секунд(ы).');

            return CommandAlias::SUCCESS;
        } catch (\Exception $exception)
        {
            $this->error('Ошибка синхронизации. Исключение: ' . $exception->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}

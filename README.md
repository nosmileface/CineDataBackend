# Movie Sync API

Простой Laravel API для демонстрации навыков владения фреймворком и синхронизации фильмов и жанров с внешнего источника. Использует очереди для обновления деталей фильмов.

## Установка

### Клонируйте репозиторий:

``` git clone https://github.com/nosmileface/CineDataBackend ```

``` cd CineDataBackend ```

### Установите зависимости через Composer:

``` composer install ```

Создайте файл `.env` и настройте его:

``` cp .env.example .env ```

``` php artisan key:generate ```

### Доступы для сервиса TMDB

``` TMDB_API_URL= ```

``` TMDB_API_KEY= ```

Убедитесь, что файл базы данных существует:

``` touch database/database.sqlite ```

Запустите миграции:

``` php artisan migrate ```

## Очереди

Создайте таблицу для очередей и мигрируйте:

``` php artisan queue:table ```
``` php artisan migrate ```

Запустите обработчик очередей:

``` php artisan queue:work --queue=genres,movies ```

## Синхронизация фильмов

Запустите команду:

``` php artisan app:import-movies ```


## API эндпоинты

Префикс: `/api/v1`

| Метод | URL | Контроллер | Назначение |
|-------|-----|------------|------------|
| GET | `/movie-genres` | `MovieGenreController@index` | Получить список жанров |
| GET | `/movies` | `MovieController@index` | Список фильмов |
| GET | `/movies/{movie}` | `MovieController@show` | Детали фильма |


GET /movie-genres - (perPage / page / sort:id_desc,id_asc) - опционально

Тестовые эндпоинты (`/api/v1/test`):

- `/test/movie-genres` — тестовые жанры
- `/test/movies/{movieGenre}` — фильмы по жанру
- `/test/movies/{movie}/casts` — актёры фильма
- `/test/movies/{movie}/crews` — команда фильма
- `/test/movies/{movie}/images` — изображения
- `/test/movies/{movie}/videos` — видео


## Логирование

Логи для импорта фильмов и жанров сохраняются в каналах `import-movies` и `import-movie-genres` (настраивается в `config/logging.php`).

## Локальное тестирование логики

Получите тестовые жанры:

``` GET /api/v1/test/movie-genres ``` 

Получите фильмы по жанру:

``` GET /api/v1/test/movies/{movieGenreId} ```

Получите детали фильма:

``` GET /api/v1/test/movies/{movieId}/casts ```  
``` GET /api/v1/test/movies/{movieId}/crews ```  
``` GET /api/v1/test/movies/{movieId}/images ```  
``` GET /api/v1/test/movies/{movieId}/videos ```
 локальной разработке, синхронизации фильмов через ваши сервисы и тестированию логики через API.

<?php

namespace App\Http\Controllers\Api\V1\Movie;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Movie\IndexMovieRequest;
use App\Http\Resources\V1\Movie\IndexMovieResource;
use App\Http\Resources\V1\Movie\ShowMovieResource;
use App\Models\Movie\Movie;
use App\Repositories\Movie\MovieRepository;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    public function __construct(private MovieRepository $movieRepository){}

    public function index(IndexMovieRequest $request): JsonResponse
    {
        $movies = $this->movieRepository->getAllWithPagination(filters: $request->validated());

        return response()->json
        (
            [
                'code' => JsonResponse::HTTP_OK,
                'data' => IndexMovieResource::collection($movies)
            ]
        );
    }

    public function show(Movie $movie): JsonResponse
    {
        $movie = $this->movieRepository->find(movie: $movie);

        return response()->json
        (
            [
                'code' => JsonResponse::HTTP_OK,
                'data' => ShowMovieResource::make($movie)
            ]
        );
    }
}

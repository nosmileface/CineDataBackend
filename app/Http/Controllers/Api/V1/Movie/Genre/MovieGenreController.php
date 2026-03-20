<?php

namespace App\Http\Controllers\Api\V1\Movie\Genre;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Movie\Genre\IndexMovieGenreRequest;
use App\Http\Resources\V1\Movie\Genre\IndexMovieGenreResource;
use App\Repositories\Movie\Genre\MovieGenreRepository;
use Illuminate\Http\JsonResponse;

class MovieGenreController extends Controller
{
    public function __construct(private MovieGenreRepository $movieGenreRepository){}

    public function index(IndexMovieGenreRequest $request): JsonResponse
    {
        $movieGenres = $this->movieGenreRepository->getAllWithPagination(filters: $request->validated());

        return response()->json
        (
            [
                'code' => JsonResponse::HTTP_OK,
                'data' => IndexMovieGenreResource::collection($movieGenres)
            ]
        );
    }
}

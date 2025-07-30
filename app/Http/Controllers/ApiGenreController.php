<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiGenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $genres = Genre::paginate(5);
        
        return response()->json($genres);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        $products = $genre->first();
        $films = Film::with(['genres' => function ($query) use ($genre) {
            $query->where('films_to_genres.genre_id', $genre->first()->id);
        }])->paginate(5);
        
        return response()->json($films);
    }
}

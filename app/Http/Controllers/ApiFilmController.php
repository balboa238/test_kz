<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiFilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $films = Film::paginate(5);
        
        return response()->json($films);
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        return response()->json($film->first());
    }
}

<?php

use App\Http\Controllers\ApiFilmController;
use App\Http\Controllers\ApiGenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/films', [ApiFilmController::class, 'index']);
Route::get('/films/{id}', [ApiFilmController::class, 'show']);
Route::get('/genres', [ApiGenreController::class, 'index']);
Route::get('/genres/{id}', [ApiGenreController::class, 'show']);
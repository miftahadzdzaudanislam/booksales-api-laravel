<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route books
Route::apiResource('/books', BookController::class);

// Route genres
Route::apiResource('/genres', GenreController::class);

// Route authors
Route::apiResource('/authors', AuthorController::class);
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authenticated user info
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Route books
Route::apiResource('/books', BookController::class)->only(['index', 'show']);

// Route genres
Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);

// Route authors
Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);

// Auth Routes
Route::middleware(['auth:api'])->group(function () {
    // Route transactions
    Route::apiResource('/transactions', TransactionController::class)->only('index', 'store', 'show');
    
    // Routes for admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('/books', BookController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/transactions', TransactionController::class)->only('update', 'destroy');
    });
    
});
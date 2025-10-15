<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // fungsi untuk menampilkan daftar genre
    public function index() {
        $genres = Genre::all(); // Mengambil semua data genre

        return response()->json([
            'status' => true,
            'message' => 'Get All Resources',
            'genres' => $genres
        ]);
    }
}

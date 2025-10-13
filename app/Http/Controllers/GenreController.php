<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // fungsi untuk menampilkan daftar genre
    public function index() {
        $data = new Genre(); // Inisialisasi model Genre
        $genres = $data->getGenres(); // mengambil data genre dari model

        return view('genres', ['genres' => $genres]);
    }
}

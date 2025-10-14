<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // fungsi untuk menampilkan daftar author
    public function index() {
        $authors = Author::all(); // Mengambil semua data author

        return view('authors', ['authors' => $authors]);
    }
}

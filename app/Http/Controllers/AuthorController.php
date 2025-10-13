<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // fungsi untuk menampilkan daftar author
    public function index() {
        $data = new Author(); // Inisialisasi model Author
        $authors = $data->getAuthors(); // mengambil data author dari model

        return view('authors', ['authors' => $authors]);
    }
}

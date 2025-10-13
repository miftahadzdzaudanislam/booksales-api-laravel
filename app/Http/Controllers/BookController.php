<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Fungsi untuk menampilkan daftar buku 
    public function index() {
        $data = new Book(); // Inisialisasi model Book
        $books = $data->getBooks(); // mengambil data buku dari model

        return view('books', ['books' => $books]);
    }
}

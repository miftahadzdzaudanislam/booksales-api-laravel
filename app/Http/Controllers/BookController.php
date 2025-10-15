<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Fungsi untuk menampilkan daftar buku 
    public function index() {
        $books = Book::all(); // Mengambil semua data buku

        return response()->json([
            'status' => true,
            'message' => 'Get All Resources',
            'books' => $books
        ], 200);
    }
}

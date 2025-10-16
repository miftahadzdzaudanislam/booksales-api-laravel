<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    // fungsi untuk menampilkan daftar genre
    public function index() {
        $genres = Genre::all(); // Mengambil semua data genre

        // Jika data genre kosong
        if ($genres->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Resource data not found!'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get All Resources',
            'data' => $genres
        ], 200);
    }

    // fungsi untuk menambahkan genre baru
    public function store(Request $request) {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
        ]);

        // 2. Check validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Insert data
        $genre = Genre::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // 4. Response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully',
            'data' => $genre
        ], 201);
    }
}

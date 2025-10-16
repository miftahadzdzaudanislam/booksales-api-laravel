<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    // fungsi untuk menampilkan daftar author
    public function index() {
        $authors = Author::all(); // Mengambil semua data author

        // Jika data author kosong
        if ($authors->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Resource data not found!'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get All Resources',
            'data' => $authors
        ], 200);
    }

    // fungsi untuk menambahkan author baru
    public function store(Request $request) {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'required|string',
        ]);

        // 2. Check validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Upload image
        $image = $request->file('photo');
        $image->store('authors', 'public');

        // 4. Insert data
        $author = Author::create([
            'name' => $request->name,
            'photo' => $image->hashName(),
            'bio' => $request->bio,
        ]);

        // 5. Response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully',
            'data' => $author
        ], 201);
    }
}

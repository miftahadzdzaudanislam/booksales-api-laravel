<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // Fungsi untuk menampilkan daftar buku 
    public function index() {
        // Mengambil semua data buku beserta genre dan author
        $books = Book::with('genre', 'author')->get();

        // Jika data buku kosong
        if ($books->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Resource data Books not found!'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get All Books',
            'data' => $books
        ], 200);
    }

    // Fungsi untuk menambahkan buku baru
    public function store(Request $request) {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        // 2. Check validator error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }
        
        // 3. Upload image
        $image = $request->file('cover_photo');
        $image->store('books', 'public');

        // 4. Insert data
        $book = Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'cover_photo' => $image->hashName(),
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id
        ]);

        // 5. response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully',
            'data' => $book
        ], 201);
    }

    // Fungsi untuk menampilkan detail buku berdasarkan ID
    public function show(string $id) {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Book not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail book',
            'data' => $book
        ], 200);
    }

    // Fungsi untuk memperbarui data buku
    public function update(Request $request, string $id) {
        // 1. Mencari data
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Book not found'
            ], 404);
        }

        // 2. Validator
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan data yang ingin diupdate
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id
        ];

        // 4. handle image (upload & delete image)
        if ($request->hasFile('cover_photo')) {
            // Upload cover photo baru
            $image = $request->file('cover_photo');
            $image->store('books', 'public');

            // Hapus cover photo lama dari storage
            if ($book->cover_photo) {
                Storage::disk('public')->delete('books/' . $book->cover_photo);
            }

            $data['cover_photo'] = $image->hashName();
        }

        // 5. Update data baru ke database
        $book->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully',
            'data' => $book
        ], 200);
    }

    // Fungsi untuk menghapus buku
    public function destroy(string $id) {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Book not found'
            ], 404);
        }

        $book->delete();

        // Hapus cover photo dari storage
        if ($book->cover_photo) {
            Storage::disk('public')->delete('books/' . $book->cover_photo);
        }

        return response()->json([
            'success' => true,
            'message' => 'Delete book successfully'
        ]);
    }
}

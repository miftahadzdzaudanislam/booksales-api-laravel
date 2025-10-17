<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    // fungsi untuk menampilkan detail author
    public function show(string $id) {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Author not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail Author',
            'data' => $author
        ], 200);
    }

    // fungsi untuk mengupdate data author
    public function update(Request $request, string $id) {
        // 1. Mencari data
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Author not found!'
            ], 404);
        }

        // 2. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan data yang ingin diupdate
        $data = [
            'name' => $request->name,
            'bio' => $request->bio,
        ];  

        // 4. Upload image
        if ($request->hasFile('photo')) {
            // Upload image
            $image = $request->file('photo');
            $image->store('authors', 'public');

            // Hapus foto lama jika ada
            if ($author->photo) {
                Storage::disk('public')->delete('authors/' . $author->photo);
            }

            $data['photo'] = $image->hashName();
        }

        // 5. Update data
        $author->update($data);

        // 6. Response
        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully',
            'data' => $author
        ], 200);
    }

    // fungsi untuk menghapus data author
    public function destroy(string $id) {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Author not found!'
            ], 404);
        }

        $author->delete();

        // Hapus foto lama jika ada
        if ($author->photo) {
            Storage::disk('public')->delete('authors/' . $author->photo);
        }

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully'
        ]);
    }
}

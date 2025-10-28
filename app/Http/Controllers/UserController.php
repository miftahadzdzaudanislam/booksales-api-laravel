<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Fungsi untuk menampilkan semua user
    public function index() {
        $user = User::all();

        // Jika data users kosong
        if ($user->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data User not found!'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get all User',
            'data' => $user
        ], 200);
    }

    // Fungsi untuk menghapus data user
    public function destroy(string $id) {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data user not found!'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }

    // Fungsi untuk menampilkan profile user
    public function showProfile() {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Profile not found!'
            ], 404);
        }

        return response()->json([
            'succecc' => true,
            'message' => 'Get Profile user',
            'data' => $user,
        ], 200);
    }
}

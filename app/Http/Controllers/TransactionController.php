<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\get;

class TransactionController extends Controller
{
    // Fungsi untuk menampilkan semua transaksi
    public function index() {
        $transaction = Transaction::with('user', 'book')->get();

        // Jika transaksi kosong
        if ($transaction->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Transactions not found!'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get all Transactions',
            'data' => $transaction
        ], 200);
    }

    // Fungsi untuk menambah data transaksi
    public function store(Request $request) {
        // 1. Validator dan Cek Validator
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 2. generate order_number -> unique | ORD-xxxx
        $uniqueCode = 'ORD-'. strtoupper(uniqid());

        // 3. Ambil user yang sedanga login & cek login (apakah ada data user?)
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized!'
            ], 401);
        }

        // 4. Mencari data buku dari request
        $book = Book::find($request->book_id);
        
        // 5. Cek status buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock of goods'
            ], 400);
        }
        
        // 6. Hitung total harga = price * quantity
        $totalAmount = $book->price * $request->quantity;

        // 7. Kurangi data buku (update)
        $book->stock -= $request->quantity;
        $book->save();

        // 8. Simpan data transaksi
        $transaction = Transaction::create([
            'order_number' => $uniqueCode,
            'customer_id' => $user->id,
            'book_id' => $request->book_id,
            'total_amount' => $totalAmount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully!',
            'data' => $transaction,
        ],201);
    }

    // Fungsi untuk menampilkan detail transaksi berdasarkan ID
    public function show(string $id) {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Transaction not found!'
            ], 404);
        }

        return response()->json([
            'succecc' => true,
            'message' => 'Get detail transaction',
            'data' => $transaction,
        ], 200);
    }

    // Fungsi untuk memperbarui data transaction
    public function update(Request $request, string $id) {
        // 1. Mencari data
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Transaction not found!'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'total_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $uniqueCode = 'ORD-'. strtoupper(uniqid());

        // 3. update data transaction ke database
        $transaction->update([
            'order_number' => $uniqueCode,
            'customer_id' => $request->customer_id,
            'book_id' => $request->book_id,
            'total_amount' => $request->total_amount . '.00',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction updated successfully!',
            'data' => $transaction,
        ], 200);

    }

    // Fungsi untuk menghapus transaksi
    public function destroy(string $id) {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Transaction not found!'
            ], 404);
        }

        // kembalikan stok
        $book = Book::find($transaction->book_id);

        $quantity = $transaction->total_amount / $book->price;
        
        $book->stock += $quantity;
        $book->save();

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete transaction successfully!'
        ]);
    }

    // Fungsi untuk menampilkan transaksi berdasarkan user yang login
    public function myTransactions() {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Profile not found!'
            ], 404);
        }

        $transaction = Transaction::with('book', 'user')
            ->where('customer_id', $user->id)->get();

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Transactions not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get Transaction user',
            'data' => $transaction,
        ], 200);
    }

    // Fungsi untuk menghapus transaksi berdasarkan user yang login
    public function destroyMyTransaction(string $id) {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized!'
            ], 401);
        }
        
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource data Transaction not found!'
            ], 404);
        }

        // kembalikan stok
        $book = Book::find($transaction->book_id);

        $quantity = $transaction->total_amount / $book->price;
        
        $book->stock += $quantity;
        $book->save();

        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete transaction successfully!'
        ]);
    }
}

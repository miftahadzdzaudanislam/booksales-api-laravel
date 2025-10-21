<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Data Transaction
    protected $table = 'transactions';

    // Kolom yang dapat diisi
    protected $fillable = [
        'order_number', 'customer_id', 'book_id', 'total_amount' 
    ];

    // Relations
    public function user() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }
}

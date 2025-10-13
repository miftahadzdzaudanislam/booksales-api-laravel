<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Data buku statis
    private $books = [
        [
            'id' => 1,
            'title' => 'Harry Potter and the Sorcerers Stone',
            'description' => 'The first book in the Harry Potter series.',
            'price' => 25000,
            'stock' => 37,
            'cover_photo' => 'harry_poter.jpg',
            'genre_id' => 1,
            'author_id' => 1,
        ],
        [
            'id' => 2,
            'title' => 'The Lord of the Rings',
            'description' => 'A classic fantasy novel by J.R.R. Tolkien.',
            'price' => 60000,
            'stock' => 30,
            'cover_photo' => 'the_lord_of_the_rings.jpg',
            'genre_id' => 1,
            'author_id' => 2,
        ],
        [
            'id' => 3,
            'title' => 'Harry Potter and the Sorcerers Stone',
            'description' => 'The first book in the Harry Potter series.',
            'price' => 25000,
            'stock' => 37,
            'cover_photo' => 'harry_poter.jpg',
            'genre_id' => 1,
            'author_id' => 1,
        ],
        [
            'id' => 4,
            'title' => '1984',
            'description' => 'A dystopian novel by George Orwell.',
            'price' => 40000,
            'stock' => 40,
            'cover_photo' => '1984.jpg',
            'genre_id' => 2,
            'author_id' => 3,
        ],
        [
            'id' => 5,
            'title' => 'The Hitchhikers Guide to the Galaxy',
            'description' => 'A comedic science fiction series by Douglas Adams.',
            'price' => 30000,
            'stock' => 20,
            'cover_photo' => 'the_hitchhikers_guide_to_the_galaxy.jpg',
            'genre_id' => 3,
            'author_id' => 3,
        ],
    ];

    // Fungsi untuk mendapatkan semua buku
    public function getBooks() {
        return $this->books;
    }
}

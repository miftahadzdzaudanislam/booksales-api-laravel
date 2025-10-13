<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // Data genre statis
    private $genres = [
        [
            'id' => 1,
            'name' => 'Fiction',
            'description' => 'A literary work based on the imagination and not necessarily on fact.',
        ],
        [
            'id' => 2,
            'name' => 'Non-Fiction',
            'description' => 'A literary work based on fact and real events.',
        ],
        [
            'id' => 3,
            'name' => 'Science Fiction',
            'description' => 'A genre that deals with imaginative and futuristic concepts.',
        ],
        [
            'id' => 4,
            'name' => 'Historical Fiction',
            'description' => 'Novels based on history with fictional storytelling.',
        ],
        [
            'id' => 5,
            'name' => 'Dystopian',
            'description' => 'Stories depicting oppressive societies and governments.',
        ],
    ];

    // Fungsi untuk mendapatkan semua genre
    public function getGenres() {
        return $this->genres;
    }
}

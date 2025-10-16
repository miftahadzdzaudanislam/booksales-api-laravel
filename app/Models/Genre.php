<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    // Data genre
    protected $table = 'genres';

    // Kolom yang dapat diisi
    protected $fillable = ['name', 'description'];
}

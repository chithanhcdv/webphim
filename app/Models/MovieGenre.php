<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Pivot
{
    protected $table = 'movie_genres';
}

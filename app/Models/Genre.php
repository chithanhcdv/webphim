<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use CrudTrait;
    protected $fillable = ['name', 'slug', 'description'];

    public function movies() {
        return $this->belongsToMany(Movie::class, 'movie_genres', 'genre_id', 'movie_id');
    }
}

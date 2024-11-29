<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use CrudTrait;
    protected $fillable = ['name', 'slug', 'description', 'release_year_id', 'country_id', 'category_id',
    'director', 'studio', 'actor', 'total_episode', 'other_name', 'image', 'background_image', 'hot'];

    public function genres() {
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
    }

    public function episodes() {
        return $this->hasMany(Episode::class);
    }

    public function trailers()
    {
        return $this->hasMany(Trailer::class);
    }

    public function watchHistory() {
        return $this->hasMany(WatchHistory::class);
    }

    public function views() {
        return $this->hasOne(View::class);
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function releaseYear() {
        return $this->belongsTo(ReleaseYear::class, 'release_year_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use CrudTrait;
    protected $fillable = ['user_id', 'movie_id', 'content', 'image'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}

<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use CrudTrait;
    protected $fillable = ['movie_id', 'episode_number', 'duration', 'server1', 'server2'];

    public function movie() {
        return $this->belongsTo(Movie::class);
    }
}

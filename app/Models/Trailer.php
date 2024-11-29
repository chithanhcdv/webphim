<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trailer extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = ['movie_id', 'url', 'description'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}

<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use CrudTrait;
    protected $fillable = ['movie_id', 'views_count'];

    public function movie() {
        return $this->belongsTo(Movie::class);
    }
}

<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseYear extends Model
{
    use CrudTrait;
    protected $fillable = ['year'];

    public function movies() {
        return $this->hasMany(Movie::class);
    }
}

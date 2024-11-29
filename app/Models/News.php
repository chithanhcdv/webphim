<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use CrudTrait;
    protected $fillable = ['title', 'slug', 'content', 'title_image', 
    'content_image', 'other_content', 'other_image'];
}

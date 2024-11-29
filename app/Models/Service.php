<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServicesOrder::class);
    }
}

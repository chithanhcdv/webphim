<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'services_orders';

    protected $fillable = [
        'user_id',
        'service_id',
        'order_code',
        'payment_method',
        'service_start_at',
        'service_end_at', 
        'status',
    ];

    // Mối quan hệ với bảng users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mối quan hệ với bảng services
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use CrudTrait;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id', 
        'facebook_id',
        'avatar',
        'is_admin',
        'service_id',
        'service_start_at',
        'service_end_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function watchlist() {
        return $this->hasMany(Watchlist::class);
    }

    public function watchHistory() {
        return $this->hasMany(WatchHistory::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function serviceOrders()
    {
        return $this->hasMany(ServicesOrder::class);
    }
}

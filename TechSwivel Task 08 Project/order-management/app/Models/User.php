<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN = 1;
    const RIDER = 2;
    const CUSTOMER = 3;

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'riderId',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'notifications',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function riderOrders()
    {
        return $this->hasMany(Order::class, 'riderId');
    }

    public function customerOrders()
    {
        return $this->hasMany(Order::class, 'customerId');
    }
}

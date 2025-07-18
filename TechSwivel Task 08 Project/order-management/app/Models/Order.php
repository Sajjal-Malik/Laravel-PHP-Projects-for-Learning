<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'riderId',
        'customerId',
        'status',
        'description',
        'feedback',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function rider()
    {
        return $this->belongsTo(User::class, 'riderId')->select('id', 'name', 'email');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customerId')->select('id', 'name', 'email');
    }
}

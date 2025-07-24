<?php

namespace App\Models;

use App\Enums\AgeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'age',
        'ageStatus',
        'phoneNumber',
        'bio',
        'dob',
        'gender',
        'picture'
    ];

    protected $casts = [
        'ageStatus' => AgeStatus::class
    ];
}

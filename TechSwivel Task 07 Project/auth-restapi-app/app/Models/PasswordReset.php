<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';
    public    $timestamps = false;
    protected $primaryKey = 'email';
    public    $incrementing = false;
    protected $keyType = 'string';

    public const CREATED_AT = 'createdAt';

    protected $fillable = ['email', 'token', 'createdAt'];
}

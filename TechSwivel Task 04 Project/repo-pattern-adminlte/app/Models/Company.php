<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    protected $fillable = ['name', 'email', 'website', 'logo'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'companyId');
    }
}

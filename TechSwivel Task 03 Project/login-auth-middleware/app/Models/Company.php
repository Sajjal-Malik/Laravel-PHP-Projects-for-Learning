<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    
    protected $fillable = ['name', 'email', 'website', 'logo'];

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    public function employees(){
        
        return $this->hasMany(Employee::class, 'companyId');
    }
}

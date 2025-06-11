<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['firstName', 'lastName', 'companyId', 'email', 'phone'];

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    public function company(){
        
        return $this->belongsTo(Company::class, 'companyId');
    }
}

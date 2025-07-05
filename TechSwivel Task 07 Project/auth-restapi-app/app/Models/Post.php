<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    protected $fillable = ['title', 'image', 'detail', 'createdBy'];

    public function author()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'postId');
    }
}

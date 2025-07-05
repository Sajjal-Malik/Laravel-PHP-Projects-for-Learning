<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    protected $fillable = ['postId', 'comment', 'createdBy'];

    public function author()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'postId');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'caption',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

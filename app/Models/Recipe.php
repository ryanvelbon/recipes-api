<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'meal_type',
        'n_servings',
        'prep_time',
        'cook_time',
        'description',
        'difficulty',
        'cuisine',
        'instructions',
        'tips',
        'status',
    ];

    protected $casts = [
        'instructions' => 'array',
        'tips' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}

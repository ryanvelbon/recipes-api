<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        $recipe = Recipe::inRandomOrder()->first();

        return [
            'user_id' => User::factory(),
            'commentable_id' => $recipe ? $recipe->id : null,
            'commentable_type' => $recipe ? Recipe::class : null,
            'body' => $this->faker->sentence,
            'parent_id' => null, // optional, to be set when creating a reply
        ];
    }
}

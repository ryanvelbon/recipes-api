<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'meal_type' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner']),
            'n_servings' => $this->faker->numberBetween(1, 8),
            'prep_time' => $this->faker->numberBetween(10, 120),
            'cook_time' => $this->faker->numberBetween(10, 120),
            'description' => $this->faker->paragraph,
            'difficulty' => $this->faker->numberBetween(1, 5),
            'cuisine' => $this->faker->randomElement(['Italian', 'Turkish', 'Chinese']),
            'instructions' => [$this->faker->sentence, $this->faker->sentence, $this->faker->sentence],
            'tips' => [$this->faker->sentence, $this->faker->sentence],
            'status' => $this->faker->randomElement(['published', 'draft']),
        ];
    }
}

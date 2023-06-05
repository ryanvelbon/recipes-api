<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_a_recipe()
    {
        $recipe = Recipe::factory()->create();
        $response = $this->get('/api/recipes/' . $recipe->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $recipe->title]);
    }

    public function test_user_can_create_a_recipe()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/recipes', [
            'title' => 'Test Recipe',
            'meal_type' => 'Breakfast',
            'n_servings' => 4,
            'prep_time' => 10,
            'cook_time' => 20,
            'description' => 'This is a test recipe',
            'difficulty' => 1,
            'cuisine' => 'American',
            'instructions' => ['Step 1', 'Step 2'],
            'tips' => ['Tip 1', 'Tip 2'],
            'status' => 'published',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['title' => 'Test Recipe']);
    }

    public function test_user_can_edit_their_recipe()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put('/api/recipes/' . $recipe->id, [
            'title' => 'Updated Test Recipe',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Updated Test Recipe']);
    }

    public function test_user_cannot_edit_recipes_of_others()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->put('/api/recipes/' . $recipe->id, [
            'title' => 'Updated Test Recipe',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_their_recipe()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/api/recipes/' . $recipe->id);

        $response->assertStatus(204);
    }

    public function test_user_cannot_delete_recipes_of_others()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->delete('/api/recipes/' . $recipe->id);

        $response->assertStatus(403);
    }
}

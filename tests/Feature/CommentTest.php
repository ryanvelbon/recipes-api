<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_comment_on_a_recipe()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create();

        $response = $this->actingAs($user)->post('/api/recipes/' . $recipe->id . '/comments', [
            'body' => 'This recipe looks delicious!'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['body' => 'This recipe looks delicious!']);
    }

    public function test_user_can_comment_on_an_image()
    {
        $user = User::factory()->create();
        $image = Image::factory()->create(); // assuming you have an Image factory

        $response = $this->actingAs($user)->post('/api/images/' . $image->id . '/comments', [
            'body' => 'This is a great image!'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['body' => 'This is a great image!']);
    }

    public function test_user_can_reply_to_a_comment()
    {
        $this->seed();

        $user = User::factory()->create();
        $comment = Comment::factory()->create(); // assuming you have a Comment factory

        $response = $this->actingAs($user)->post('/api/comments/' . $comment->id . '/comments', [
            'body' => 'I totally agree!'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['body' => 'I totally agree!']);
    }

    public function test_guest_cannot_comment()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->post('/api/recipes/' . $recipe->id . '/comments', [
            'body' => 'This recipe looks delicious!'
        ]);

        $response->assertStatus(401); // unauthorized
    }

    public function test_user_can_edit_their_comment()
    {
        $this->seed();

        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put('/api/comments/' . $comment->id, [
            'body' => 'Updated comment!'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['body' => 'Updated comment!']);
    }

    public function test_user_cannot_edit_comments_of_others()
    {
        $this->seed();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->put('/api/comments/' . $comment->id, [
            'body' => 'Updated comment!'
        ]);

        $response->assertStatus(403); // forbidden
    }

    public function test_user_can_delete_their_comment()
    {
        $this->seed();

        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/api/comments/' . $comment->id);

        $response->assertStatus(204); // no content
    }

    public function test_user_cannot_delete_comments_of_others()
    {
        $this->seed();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->delete('/api/comments/' . $comment->id);

        $response->assertStatus(403); // forbidden
    }
}

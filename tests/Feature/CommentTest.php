<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

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

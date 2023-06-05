<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_follow_another_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $response = $this->actingAs($user1)->post('/api/users/' . $user2->id . '/follow');

        $response->assertStatus(200);
        $this->assertDatabaseHas('followings', [
            'follower_id' => $user1->id,
            'followee_id' => $user2->id
        ]);
    }

    public function test_user_can_unfollow_another_user()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user1->followees()->attach($user2);

        $response = $this->actingAs($user1)->delete('/api/users/' . $user2->id . '/unfollow');

        $response->assertStatus(200);
        $this->assertDatabaseMissing('followings', [
            'follower_id' => $user1->id,
            'followee_id' => $user2->id
        ]);
    }

    public function test_user_cannot_follow_themselves()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/users/' . $user->id . '/follow');

        $response->assertStatus(400);
    }

    public function test_user_cannot_follow_same_user_twice()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $response1 = $this->actingAs($user1)->post('/api/users/' . $user2->id . '/follow');
        $response1->assertStatus(200);
        $this->assertDatabaseHas('followings', [
            'follower_id' => $user1->id,
            'followee_id' => $user2->id
        ]);

        // Attempt to follow the same user again
        $response2 = $this->actingAs($user1)->post('/api/users/' . $user2->id . '/follow');
        $response2->assertStatus(409); // 409 Conflict can be used to indicate that the request could not be completed due to a conflict with the current state of the target resource
    }

    public function test_user_can_list_users_they_are_following()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user1->followees()->attach($user2);

        $response = $this->actingAs($user1)->get('/api/users/' . $user1->id . '/following');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $user2->id]);
    }

    public function test_user_can_list_users_who_are_following_them()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user2->followees()->attach($user1);

        $response = $this->actingAs($user1)->get('/api/users/' . $user1->id . '/followers');

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $user2->id]);
    }
}

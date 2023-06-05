<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function follow(User $user)
    {
        $currentUser = Auth::user();

        // Check that the user is not trying to follow themselves
        if($currentUser->id === $user->id) {
            return response()->json(['error' => 'You cannot follow yourself'], 400);
        }

        // Check if the current user is already following the target user
        if ($currentUser->followees()->where('followee_id', $user->id)->exists()) {
            return response()->json(['error' => 'You are already following this user'], 409);
        }

        $currentUser->followees()->attach($user->id);
        return response()->json(['message' => 'Followed successfully'], 200);
    }

    public function unfollow(User $user)
    {
        $currentUser = Auth::user();

        $currentUser->followees()->detach($user->id);
        return response()->json(['message' => 'Unfollowed successfully'], 200);
    }

    public function following(User $user)
    {
        $followees = $user->followees;
        return response()->json($followees, 200);
    }

    public function followers(User $user)
    {
        $followers = $user->followers;
        return response()->json($followers, 200);
    }
}

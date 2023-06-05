<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Comment $comment): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id
                    ? Response::allow()
                    : Response::deny('You do not own this comment.');
    }

    public function delete(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id
                    ? Response::allow()
                    : Response::deny('You do not own this comment.');
    }

    public function restore(User $user, Comment $comment): bool
    {
        //
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        //
    }
}

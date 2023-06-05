<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();
        $comment->body = $request->input('body');
        $comment->user_id = Auth::id();

        if ($request->route()->hasParameter('recipe')) {
            $commentable = Recipe::findOrFail($request->route('recipe'));
        }
        elseif ($request->route()->hasParameter('comment')) {
            $commentable = Comment::findOrFail($request->route('comment'));
        }
        elseif ($request->route()->hasParameter('image')) {
            $commentable = Image::findOrFail($request->route('image'));
        }
        else {
            // Handle the case where none of the expected parameters are present.
            return response()->json(['error' => 'No valid parameter found in the request.'], 400);
        }

        $commentable->comments()->save($comment);

        return response()->json($comment, 201);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->body = $request->input('body');
        $comment->save();

        return response()->json($comment, 200);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 204);
    }
}

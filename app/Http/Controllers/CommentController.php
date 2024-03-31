<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;

        $comment->user_id = $request->input('user_id');
        $comment->post_id = $request->input('post_id');
        $comment->text = $request->input('comment');
        $comment->save();

    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
    }
}

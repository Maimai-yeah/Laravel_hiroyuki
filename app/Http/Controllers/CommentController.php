<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request,Post $post) {
        $request->validate([
            'content' => 'required|max:500'
        ]);

        Comment::create([
            'post_id'=>$post->id,
            'user_id'=>Auth::id(),
            'content'=>$request->content
        ]);

        return redirect()->route('posts.show', $post->id);
    }
}

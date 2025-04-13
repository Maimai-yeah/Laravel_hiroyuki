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
            'nickname' => 'nullable|max:50',
            'content' => 'required|max:500'
        ]);

        $nickname=$request->nickname ?:'風吹けば名無し';

        Comment::create([
            'post_id'=>$post->id,
            'user_id'=>Auth::id(),
            'content'=>$request->content,
            'nickname'=>$nickname
        ]);

        return redirect()->route('posts.show', $post->id);
    }
}

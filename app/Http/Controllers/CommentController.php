<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $request->validate([
        'nickname' => 'nullable|max:50',
        'content' => 'required|max:500',
    ]);

    $nickname = $request->nickname ?: '名無し';

    // コメントの位置を計算
    $position = Comment::where('post_id', $post->id)->count() + 1;

    Comment::create([
        'post_id' => $post->id,
        'user_id' => Auth::id(),
        'content' => $request->content,
        'nickname' => $nickname,
        'position' => $position,  // position を明示的に設定
    ]);

    return redirect()->route('posts.show', $post->id);
}

    
}

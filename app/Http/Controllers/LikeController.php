<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike(Comment $comment)
{
    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    $like = $comment->likes()->where('user_id', $user->id);

    if ($like->exists()) {
        $like->delete();
        $action = 'removed';
    } else {
        $comment->likes()->create(['user_id' => $user->id]);
        $action = 'added';
    }

    // 新しいいいね数を取得
    $likeCount = $comment->likes()->count();

    return response()->json([
        'action' => $action,
        'likeCount' => $likeCount,
        'userHasLiked' => $comment->likes->contains('user_id', $user->id),
    ]);


    }
    
}

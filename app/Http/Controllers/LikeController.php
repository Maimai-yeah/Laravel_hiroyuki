<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /* 
    public function store(Comment $comment)
    {
        $user = Auth::user();
    
        // すでにいいねしてるかチェック
        if (!$comment->likedBy($user)) {
            $comment->likes()->create([
                'user_id' => $user->id,
            ]);
        }
    
        return back();
    }
 */
    public function toggleLike(Comment $comment) {
        if(!auth()->check()) {
            return redirect()->route('login');
        }

        //既にいいねしているか確認
        $user=Auth::user();
        $like=$comment->likes()->where('user_id',$user->id);

        if($like->exists()) {
            $like->delete();
        }else {
            $comment->likes()->create(['user_id' =>$user->id]);
        }

        return redirect()->back();
    }
    
    public function destroy(Comment $comment)
    {
        $user = Auth::user();
    
        $comment->likes()->where('user_id', $user->id)->delete();
    
        return back();
    }
    
}

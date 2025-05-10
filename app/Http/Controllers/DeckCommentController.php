<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\DeckComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckCommentController extends Controller
{
    // コメントを保存
    public function store(Request $request, $deckId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
        ]);

        $deck = Deck::findOrFail($deckId);
        
        $comment = new DeckComment();
        $comment->deck_id = $deck->id;
        $comment->user_id = Auth::id();  // ログイン中のユーザーID
        $comment->content = $request->content;
        $comment->nickname = $request->nickname;
        $comment->position = $deck->comments->count() + 1;  // コメントの順番
        $comment->save();

        return redirect()->route('decks.show', $deckId)->with('success', 'コメントが投稿されました');
    }

    // コメントを削除
    public function destroy($commentId)
    {
        $comment = DeckComment::findOrFail($commentId);

        // 自分のコメントだけ削除できるようにする
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', '権限がありません');
        }

        $comment->delete();
        return redirect()->back()->with('success', 'コメントが削除されました');
    }
}

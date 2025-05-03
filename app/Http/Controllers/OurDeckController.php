<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\DeckLike;
use Illuminate\Http\Request;

class OurDeckController extends Controller
{
    // みんなのデッキの一覧表示
    public function index()
    {
        // 公開されたデッキを取得
        $publicDecks = Deck::with(['user', 'cards'])
            ->where('share', true)
            ->latest()
            ->paginate(12);

        return view('posts.ourdeck', compact('publicDecks'));
    }

    // デッキの詳細表示
    public function show($id)
    {
        $deck = Deck::with(['cards', 'user'])->findOrFail($id);

        if (!$deck->share) {
            abort(404); // 非公開のデッキは表示しない
        }

        // デッキの説明を取得
        $description = $deck->description;

        return view('posts.ourdeck_show', compact('deck', 'description'));
    }

    // デッキへの「いいね」をトグル
    public function toggleLike($id)
    {
        $deck = Deck::findOrFail($id);

        // ユーザーがすでに「いいね」をしているか確認
        $like = DeckLike::where('deck_id', $deck->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            // すでに「いいね」していれば取り消し
            $like->delete();
        } else {
            // 「いいね」していなければ新たに追加
            DeckLike::create([
                'deck_id' => $deck->id,
                'user_id' => auth()->id(),
            ]);
        }

        return back();
    }
}

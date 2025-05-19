<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\DeckLike;
use Illuminate\Http\Request;

class OurDeckController extends Controller
{
    // 🔍 みんなのデッキの一覧表示
    public function index(Request $request)
    {
        $query = Deck::with(['user', 'cards', 'likes'])
            ->where('share', true); // 公開されているデッキのみ表示

        // 🔎 キーワード検索
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }

        // ❤️「いいね」したデッキのみ表示（ログイン中のみ有効）
        if ($request->filter === 'liked' && auth()->check()) {
            $likedDeckIds = auth()->user()->likedDecks()->pluck('decks.id')->toArray();
            $query->whereIn('id', $likedDeckIds);
        }

        // 🔃 並び替え（デフォルトは新着順）
        if ($request->sort === 'likes') {
            $query->withCount('likes')->orderBy('likes_count', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 📄 ページネーション（12件ずつ）
        $publicDecks = $query->paginate(12)->appends($request->query());

        return view('posts.ourdeck', compact('publicDecks'));
    }

    // 📋 デッキの詳細表示
    public function show($id)
    {
        $deck = Deck::with(['cards', 'user'])->findOrFail($id);

        if (!$deck->share) {
            abort(404); // 非公開デッキは見せない
        }

        return view('posts.ourdeck_show', compact('deck'));
    }

    // ❤️「いいね」をトグル（追加 or 削除）
    public function toggleLike($id)
    {
        $deck = Deck::findOrFail($id);

        $existingLike = DeckLike::where('deck_id', $deck->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingLike) {
            $existingLike->delete(); // すでにいいねしてたら削除
        } else {
            DeckLike::create([
                'deck_id' => $deck->id,
                'user_id' => auth()->id(),
            ]);
        }

        return back(); // 元のページに戻る
    }
}

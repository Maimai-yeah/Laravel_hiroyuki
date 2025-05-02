<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;

class OurDeckController extends Controller
{
    public function index()
    {
        $publicDecks = Deck::with(['user', 'cards'])
            ->where('share', true) // ← is_public じゃなくて share フラグに合わせる
            ->latest()
            ->paginate(12);

        return view('posts.ourdeck', compact('publicDecks'));
    }
    public function show($id)
{
    $deck = Deck::with(['cards', 'user'])->findOrFail($id);

    if (!$deck->share) {
        abort(404); // 非共有なら表示しない
    }

    return view('posts.ourdeck_show', compact('deck'));
}

}


<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;

class OsusumeDeckController extends Controller
{
   

    public function index()
    {
        // おすすめデッキを取得（例えば「is_recommended」カラムでフィルタリング）
        $recommendedDecks = Deck::where('is_recommended', true)->paginate(9);

        return view('posts.osusumedeck', compact('recommendedDecks'));
    }
    public function show(Deck $deck)
{
    // おすすめでないものに直接アクセスされた場合は403にする（任意）
    if (!$deck->is_recommended) {
        abort(403, 'おすすめデッキではありません。');
    }

    return view('posts.osusumedeck_show', compact('deck'));
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Deck;

class YourDeckController extends Controller
{
    public function yourdeck()
    {
        // ログインユーザーのデッキを取得（ページネーション付き）
        $decks = Deck::where('user_id', Auth::id())->latest()->paginate(10);

        return view('posts.yourdeck', compact('decks'));
    }
    public function show($id)
{
    $deck = Deck::with('cards')->where('user_id', Auth::id())->findOrFail($id);

    $images = [
        'ネメシス' => 'https://pbs.twimg.com/media/Gl6dJQhbYAI94qY?format=jpg&name=medium',
        'エルフ' => 'https://pbs.twimg.com/media/Gl6dPUXbEAE1HCr?format=jpg&name=medium',
        'ロイヤル' => 'https://pbs.twimg.com/media/Gl6dUvba4AEGHUE?format=jpg&name=medium',
        'ウィッチ' => 'https://pbs.twimg.com/media/Gl6dZoIbYAIp8Cb?format=jpg&name=medium',
        'ドラゴン' => 'https://pbs.twimg.com/media/Gl6dekbbYAMuH1A?format=jpg&name=medium',
        'ナイトメア' => 'https://pbs.twimg.com/media/Gl6doo_bEAAlacW?format=jpg&name=medium',
        'ビショップ' => 'https://pbs.twimg.com/media/Gl6dyWyawAAyuAi?format=jpg&name=medium',
    ];

    $leaderImage = $images[$deck->class] ?? null;

    return view('posts.yourdeck_show', compact('deck', 'leaderImage'));
}


public function destroy($id)
{
    $deck = Deck::where('user_id', Auth::id())->findOrFail($id);
    $deck->delete();

    return redirect()->route('posts.yourdeck')->with('success', 'デッキを削除しました。');
}
}

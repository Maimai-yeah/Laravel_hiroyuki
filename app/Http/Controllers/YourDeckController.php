<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Deck;
use Illuminate\Support\Facades\Log;

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
public function shareDeck($id)
{
    $deck = Deck::findOrFail($id);
    
    if ($deck->user_id !== auth()->id()) {
        return redirect()->back()->with('error', '権限がありません');
    }

    try {
        // デッキを公開状態にする
        $deck->update(['share' => true]);
        return redirect()->route('posts.yourdeck')->with('success', 'デッキが共有されました');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'デッキの共有に失敗しました。');
    }
}
public function unshareDeck($id)
{
    $deck = Deck::findOrFail($id);

    // デッキの所有者か確認
    if ($deck->user_id !== auth()->id()) {
        return redirect()->back()->with('error', '権限がありません');
    }

    try {
        // 共有を取り消し（shareをfalseにする）
        $deck->update(['share' => false]);
        return redirect()->route('posts.yourdeck')->with('success', 'デッキの共有が取り消されました');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'デッキの共有取り消しに失敗しました');
    }
}
public function updateDescription(Request $request, $id)
{
    $deck = Deck::where('user_id', Auth::id())->findOrFail($id);

    $request->validate([
        'description' => 'nullable|string|max:500',
    ]);

    try {
        // デッキの説明を更新
        $deck->description = $request->input('description');
        $deck->save();

        // 保存成功メッセージをフラッシュセッションに設定
        return redirect()->route('yourdeck.show', $deck->id)->with('success', '保存に成功しました！');
    } catch (\Exception $e) {
        // 保存失敗時のエラーメッセージをフラッシュセッションに設定
        return redirect()->route('yourdeck.show', $deck->id)->with('error', '保存に失敗しました');
    }
}



}

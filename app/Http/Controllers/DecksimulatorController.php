<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use Illuminate\Support\Facades\Auth;
use App\Models\Deck;

class DecksimulatorController extends Controller
{
    /**
     * リーダー選択画面
     */
    public function leaderselect()
    {
        return view('posts.leaderselect');
    }

    /**
     * デッキシミュレータ画面 ＋ 検索（通常 / Ajax）
     */
    public function decksimulator(Request $request)
    {
        $sortBy = $request->input('sort_by', 'created_at');
        $selectedClass = $request->input('class'); // URLから選択されたクラスを取得

        $query = Card::query();

        // クラスフィルター：指定されたクラス + ニュートラル
        if ($selectedClass) {
            $query->whereIn('class', [$selectedClass, 'ニュートラル']);
        }

        // ▼ その他フィルター
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('card_type')) {
            $query->where('card_type', $request->input('card_type'));
        }
        if ($request->filled('version')) {
            $query->where('version', $request->input('version'));
        }
        if ($request->filled('cost')) {
            $query->where('cost', $request->input('cost'));
        }
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->input('rarity'));
        }

        // 並び替え + ページネーション
        $cards = $query->orderBy($sortBy, 'desc')->paginate(20)->appends($request->query());

        // Ajax用レスポンス
        if ($request->ajax()) {
            $cardsView = view('partials.card_list', compact('cards'))->render();
            return response()->json([
                'cards' => $cardsView,
            ]);
        }

        // 通常のビュー表示
        return view('posts.decksimulator', compact('cards', 'selectedClass'));
    }

    /**
     * 特定カードの詳細情報をJSONで返す
     */
    public function getCardInfo($id)
    {
        $card = Card::find($id);

        if ($card) {
            return response()->json([
                'name' => $card->name,
                'cost' => $card->cost,
                'attack' => $card->attack,
                'hp' => $card->hp,
                'class' => $card->class,
                'rarity' => $card->rarity,
                'version' => $card->version,
                'effect' => $card->effect,
                'evolved_name' => $card->evolved_name,
                'image_url' => $card->image_url,
            ]);
        }

        return response()->json(['error' => 'カードが見つかりませんでした'], 404);
    }

    /**
     * デッキを保存する
     */
    public function saveDeck(Request $request)
    {
        // ログインしていない場合はエラーを返す
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'ログインが必要です']);
        }

        // リクエストデータのバリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:255',
            'deck' => 'required|array|min:1',  // デッキが1枚以上
            'deck.*.card_id' => 'required|exists:cards,id',  // カードIDは存在する必要あり
            'deck.*.count' => 'required|integer|min:1|max:3',  // カードの枚数は1〜3
        ]);

        // 現在ログインしているユーザーを取得
        $user = Auth::user();

        // ユーザーごとのデッキ保存ロジック
        try {
            // デッキを作成（decks テーブルに保存）
            $deck = $user->decks()->create([
                'name' => $validated['name'],
                'class' => $validated['class'], // クラスも保存する
            ]);

            // 中間テーブルにカードと枚数を保存（deck_card テーブルなどを想定）
            foreach ($validated['deck'] as $item) {
                $deck->cards()->attach($item['card_id'], ['quantity' => $item['count']]);
            }

            // 成功のレスポンス
            return response()->json(['success' => true, 'message' => 'デッキが保存されました']);
        } catch (\Exception $e) {
            // 例外が発生した場合はエラーレスポンスを返す
            return response()->json(['success' => false, 'message' => 'デッキの保存に失敗しました: ' . $e->getMessage()]);
        }
    }
}

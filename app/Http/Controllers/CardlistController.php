<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card; // 追加！

class CardlistController extends Controller
{
    public function cardlist(Request $request)
{
    $sortBy = $request->input('sort_by', 'created_at');

    // クエリビルダ
    $query = Card::query();

    // フィルター条件の追加
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->input('name') . '%');
    }
    if ($request->filled('card_type')) {
        $query->where('card_type', $request->input('card_type'));
    }
    

    if ($request->filled('class')) {
        $query->where('class', $request->input('class'));
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

    // 並び替えとページネーション
    $cards = $query->orderBy($sortBy, 'desc')->paginate(20)->appends($request->query());

    return view('posts.cardlist', compact('cards'));
}


    public function getCardInfo($id)
    {
        $card = Card::find($id);

        if ($card) {
            return response()->json([
                'name' => $card->name,
                'cost' => $card->cost,
                'attack' => $card->attack,
                'hp' => $card->hp,
                'class'=>$card->class,
                'rarity'=>$card->rarity,
                'version' => $card->version,
                'effect' => $card->effect,
                'evolved_name' => $card->evolved_name,
                'image_url' => $card->image_url,
            ]);
        } else {
            return response()->json(['error' => 'カードが見つかりませんでした'], 404);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'name',
        'image_url',
        'cost',
        'version',
        'class',
        'rarity',
        'attack',
        'hp',
        'effect',
        'evolved_name',
        'card_type', 
    ];
    public function decks()
{
    return $this->belongsToMany(Deck::class, 'deck_card')
                ->withPivot('quantity')
                ->withTimestamps();
}
// Card.php の中に追加
public function getClassEnAttribute()
{
    $map = [
        'ニュートラル' => 'neutral',
        'エルフ' => 'elf',
        'ロイヤル' => 'royal',
        'ウィッチ' => 'witch',
        'ドラゴン' => 'dragon',
        'ナイトメア' => 'nightmare',
        'ビショップ' => 'bishop',
        'ネメシス' => 'nemesis',
    ];

    return $map[$this->class] ?? $this->class;
}


}

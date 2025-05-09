<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeckComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'deck_id', 'user_id', 'content', 'nickname', 'position'
    ];

    // Deckとのリレーション
    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    // Userとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

// app/Models/DeckLike.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeckLike extends Model
{
    use HasFactory;

    protected $table = 'deck_like';

    protected $fillable = ['user_id', 'deck_id'];

    // ユーザーとデッキの関連付け
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}

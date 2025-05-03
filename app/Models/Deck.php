<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = ['name', 'class', 'user_id', 'share'];  // 'share'カラムを追加

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // カードとのリレーション
    public function cards()
    {
        return $this->belongsToMany(\App\Models\Card::class, 'deck_card')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // いいねとのリレーション
    public function likes()
    {
        return $this->hasMany(\App\Models\DeckLike::class);
    }

    // ユーザーがデッキにいいねをしているかどうかを確認するメソッド
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}

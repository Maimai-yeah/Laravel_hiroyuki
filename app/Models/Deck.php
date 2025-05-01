<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    // これを追加！
    protected $fillable = ['name'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function cards()
{
    return $this->belongsToMany(\App\Models\Card::class, 'deck_card') // ← ここを追加
                ->withPivot('quantity')
                ->withTimestamps();
}

}

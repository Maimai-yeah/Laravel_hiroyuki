<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $fillable = ['name', 'class', 'user_id', 'share'];  // 'share'カラムを追加

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function cards()
    {
        return $this->belongsToMany(\App\Models\Card::class, 'deck_card')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}


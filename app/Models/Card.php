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
        'evolved_name'
    ];
}

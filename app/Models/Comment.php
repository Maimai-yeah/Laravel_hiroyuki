<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use SebastianBergmann\FileIterator\Factory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable=[
        'post_id',
        'user_id',
        'content',
        'nickname',
        'position'
    ];

    protected static function booted()
    {
        static::creating(function ($comment) {
            if ($comment->position === null) {
                $comment->position = 0; // デフォルト値を設定
            }
        });
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}

<?php

// database/migrations/xxxx_xx_xx_create_deck_like_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeckLikeTable extends Migration
{
    public function up()
    {
        Schema::create('deck_like', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // ユーザーの外部キー
            $table->foreignId('deck_id')->constrained()->onDelete('cascade');  // デッキの外部キー
            $table->timestamps();

            $table->unique(['user_id', 'deck_id']);  // ユーザーとデッキの組み合わせを一意にする
        });
    }

    public function down()
    {
        Schema::dropIfExists('deck_like');
    }
}

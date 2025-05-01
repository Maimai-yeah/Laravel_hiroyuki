<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->id();               // デッキID
            $table->foreignId('user_id') // 外部キー（usersテーブルのID）
                ->constrained()         // 'users' テーブルを参照
                ->onDelete('cascade');  // ユーザー削除時にデッキも削除
            $table->string('name');      // デッキ名
            $table->timestamps();       // 作成日時、更新日時

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decks');
    }
};

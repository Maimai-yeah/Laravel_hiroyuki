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
        Schema::create('deck_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deck_id')->constrained()->onDelete('cascade'); // deckテーブルとのリレーション
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // userテーブルとのリレーション
            $table->text('content'); // コメント内容
            $table->timestamps();
            $table->string('nickname')->nullable(); // 任意でニックネーム
            $table->unsignedInteger('position')->nullable(); // コメントの順番
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deck_comments');
    }
};

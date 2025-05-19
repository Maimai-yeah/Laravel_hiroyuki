<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deck_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('deck_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'deck_id']); // 同じユーザーが同じデッキに2回いいねできないように
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deck_likes');
    }
};

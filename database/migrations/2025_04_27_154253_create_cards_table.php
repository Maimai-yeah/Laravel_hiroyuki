<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();  // id (AUTO_INCREMENT)
            $table->string('name');  // カード名
            $table->string('image_url');  // 画像URL
            $table->integer('cost');  // コスト
            $table->string('class')->nullable(); // 例: Runecraft
            $table->string('rarity')->nullable(); // 例: Silver
            $table->string('version', 50)->nullable();  // バージョン
            $table->integer('attack')->nullable();  // 攻撃力
            $table->integer('hp')->nullable();  // HP
            $table->text('effect')->nullable();  // 効果
            $table->string('evolved_name')->nullable();  // 進化後カードの名前
            $table->timestamps();  // created_at と updated_at カラムを追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}

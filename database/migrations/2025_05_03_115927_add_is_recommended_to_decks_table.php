<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('decks', function (Blueprint $table) {
        $table->boolean('is_recommended')->default(false); // おすすめフラグを追加
    });
}

public function down()
{
    Schema::table('decks', function (Blueprint $table) {
        $table->dropColumn('is_recommended');
    });
}

};

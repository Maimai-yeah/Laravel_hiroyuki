<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShareToDecksTable extends Migration
{
    public function up()
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->boolean('share')->default(false);  // shareカラムを追加
        });
    }

    public function down()
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->dropColumn('share');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShareToDecksTable extends Migration
{
    public function up()
    {
        Schema::table('decks', function (Blueprint $table) {
            // shareカラムをboolean型で追加し、デフォルト値をfalseに設定
            $table->boolean('share')->default(false);
        });
    }

    public function down()
    {
        Schema::table('decks', function (Blueprint $table) {
            $table->dropColumn('share');
        });
    }
}

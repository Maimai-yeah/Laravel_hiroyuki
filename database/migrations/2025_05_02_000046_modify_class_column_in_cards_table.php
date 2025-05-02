<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyClassColumnInCardsTable extends Migration
{
    public function up()
    {
        // MySQLではENUMの再定義が必要です
        DB::statement("ALTER TABLE cards MODIFY `class` ENUM('ネメシス', 'エルフ', 'ロイヤル', 'ウィッチ', 'ドラゴン', 'ナイトメア', 'ビショップ', 'ニュートラル') NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE cards MODIFY `class` ENUM('ネメシス', 'エルフ', 'ロイヤル', 'ウィッチ', 'ドラゴン', 'ナイトメア', 'ビショップ') NULL");
    }
}

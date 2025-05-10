<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->longText('content')->change();  // contentカラムをLONGTEXT型に変更
    });
}

public function down()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->text('content')->change();  // 元に戻す（必要な場合）
    });
}

};

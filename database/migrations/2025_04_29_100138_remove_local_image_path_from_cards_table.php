<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('cards', function (Blueprint $table) {
        $table->dropColumn('local_image_path'); // local_image_pathカラムを削除
    });
}

public function down()
{
    Schema::table('cards', function (Blueprint $table) {
        $table->string('local_image_path')->nullable(); // 必要であれば元のカラムを追加する
    });
}

};

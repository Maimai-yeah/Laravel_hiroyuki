<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /// database/migrations/xxxx_xx_xx_xxxxxx_add_description_to_decks_table.php

public function up()
{
    Schema::table('decks', function (Blueprint $table) {
        $table->text('description')->nullable();  // 説明を追加
    });
}

public function down()
{
    Schema::table('decks', function (Blueprint $table) {
        $table->dropColumn('description');
    });
}

};

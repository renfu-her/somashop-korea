<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_specification_items', function (Blueprint $table) {
            // 先刪除舊的外鍵約束（如果存在）
            $table->dropForeign(['product_specification_id']);
            $table->dropColumn('product_specification_id');

            // 添加新的欄位和外鍵
            $table->foreignId('specification_id')
                ->constrained('product_specifications')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('product_specification_items', function (Blueprint $table) {
            $table->dropForeign(['specification_id']);
            $table->dropColumn('specification_id');

            $table->foreignId('product_specification_id')
                ->constrained('product_specifications')
                ->onDelete('cascade');
        });
    }
};

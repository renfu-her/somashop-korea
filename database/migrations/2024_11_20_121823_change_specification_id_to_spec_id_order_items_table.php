<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // 先刪除原有的外鍵約束
            $table->dropForeign(['specification_id']);

            // 重命名欄位
            $table->renameColumn('specification_id', 'spec_id');

            // 添加新的外鍵約束
            $table->foreign('spec_id')
                ->references('id')
                ->on('product_specs')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // 先刪除新的外鍵約束
            $table->dropForeign(['spec_id']);

            // 還原欄位名稱
            $table->renameColumn('spec_id', 'specification_id');

            // 重新添加原有的外鍵約束
            $table->foreign('specification_id')
                ->references('id')
                ->on('product_specifications')
                ->onDelete('set null');
        });
    }
};

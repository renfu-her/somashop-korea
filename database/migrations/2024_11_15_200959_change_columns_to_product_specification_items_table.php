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
        Schema::table('product_specification_items', function (Blueprint $table) {
            // 檢查列是否存在，如果存在則刪除
            if (Schema::hasColumn('product_specification_items', 'product_specification_id')) {
                $table->dropForeign(['product_specification_id']);
                $table->dropColumn('product_specification_id');
            }

            // 檢查新列是否不存在，如果不存在則添加
            if (!Schema::hasColumn('product_specification_items', 'specification_id')) {
                $table->foreignId('specification_id')
                    ->after('product_id')
                    ->constrained('product_specifications')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_specification_items', function (Blueprint $table) {
            // 檢查列是否存在，如果存在則刪除
            if (Schema::hasColumn('product_specification_items', 'specification_id')) {
                $table->dropForeign(['specification_id']);
                $table->dropColumn('specification_id');
            }

            // 檢查舊列是否不存在，如果不存在則添加
            if (!Schema::hasColumn('product_specification_items', 'product_specification_id')) {
                $table->foreignId('product_specification_id')
                    ->constrained('product_specifications')
                    ->onDelete('cascade');
            }
        });
    }
};

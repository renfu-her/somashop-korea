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
        Schema::table('orders', function (Blueprint $table) {
               // 移除外鍵約束
            $table->dropForeign('orders_user_id_foreign');
            
            // 移除索引
            $table->dropIndex('orders_user_id_foreign');
            
             // 重新定義 member_id 欄位，但不設置外鍵約束
             $table->unsignedBigInteger('member_id')->change();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 恢復外鍵約束
            $table->foreign('member_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};

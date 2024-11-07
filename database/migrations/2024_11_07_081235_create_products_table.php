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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');     // 商品名稱
            $table->string('slug')->unique(); // 商品別名
            $table->text('description'); // 商品描述
            $table->decimal('price', 10, 2); // 價格
            $table->integer('stock');    // 庫存
            $table->foreignId('category_id')->constrained(); // 分類ID
            $table->string('image')->nullable(); // 商品圖片
            $table->boolean('is_active')->default(true); // 是否上架
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

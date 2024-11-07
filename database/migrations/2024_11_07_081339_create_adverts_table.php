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
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->string('title');    // 廣告標題
            $table->text('description'); // 廣告描述
            $table->string('image');     // 廣告圖片
            $table->string('url')->nullable(); // 廣告連結
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->timestamp('start_date'); // 開始時間
            $table->timestamp('end_date')->nullable(); // 結束時間
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
    }
};

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
        Schema::create('home_ads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('廣告標題');
            $table->string('image')->comment('圖片檔名');
            $table->string('link')->nullable()->comment('連結網址');
            $table->boolean('is_active')->default(true)->comment('啟用狀態');
            $table->integer('sort_order')->default(0)->comment('排序順序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_ads');
    }
};

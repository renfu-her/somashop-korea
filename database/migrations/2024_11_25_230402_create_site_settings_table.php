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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->comment('網站名稱');
            $table->string('site_description')->nullable()->comment('網站描述');
            $table->string('meta_title')->nullable()->comment('SEO 標題');
            $table->string('meta_description')->nullable()->comment('SEO 描述');
            $table->string('meta_keywords')->nullable()->comment('SEO 關鍵字');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

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
        Schema::table('seal_knowledges', function (Blueprint $table) {
            // 新增 SEO 相關欄位
            $table->string('meta_title')->nullable()->after('status');
            $table->string('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seal_knowledges', function (Blueprint $table) {
            // 刪除 SEO 相關欄位
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_keywords',
            ]);
        });
    }
};

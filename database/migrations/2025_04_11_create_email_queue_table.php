<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('subject');
            $table->text('content');
            $table->string('template')->nullable();
            $table->json('data')->nullable();
            $table->json('bcc')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->integer('attempts')->default(0);
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('scheduled_at')->nullable()->comment('預定發送時間');
            $table->string('priority')->default('normal')->comment('優先級：high, normal, low');
            $table->string('type')->nullable()->comment('郵件類型：order, notification, marketing 等');
            
            // 修正 morphs 的定義
            $table->string('mailable_type')->nullable();
            $table->unsignedBigInteger('mailable_id')->nullable();
            $table->index(['mailable_type', 'mailable_id']);
            
            $table->timestamps();

            // 索引
            $table->index('status');
            $table->index('attempts');
            $table->index('scheduled_at');
            $table->index('priority');
            $table->index('type');
            $table->index(['status', 'attempts', 'scheduled_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_queue');
    }
}; 
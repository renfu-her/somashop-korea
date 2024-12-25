<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('image_upload_types', function (Blueprint $table) {
            $table->id();
            $table->boolean('multi_upload')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('image_upload_types');
    }
};

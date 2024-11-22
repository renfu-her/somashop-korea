<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_specs', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('sort_order');
            $table->decimal('price', 10, 0)->default(0)->after('value');
        });
    }

    public function down()
    {
        Schema::table('product_specs', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'price']);
        });
    }
}; 
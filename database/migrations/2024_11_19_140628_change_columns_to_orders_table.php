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
            $table->string('recipient_name')->nullable()->change();
            $table->string('recipient_phone')->nullable()->change();
            $table->string('shipping_address')->nullable()->change();
            $table->string('shipping_method')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('recipient_name')->change();
            $table->string('recipient_phone')->change();
            $table->string('shipping_address')->change();
            $table->string('shipping_method')->change();
        });
    }
};

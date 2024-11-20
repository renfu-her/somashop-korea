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
            $table->string('logistics_id')->nullable();
            $table->string('logistics_type')->nullable();
            $table->string('logistics_sub_type')->nullable();
            $table->string('cvs_payment_no')->nullable();
            $table->string('cvs_validation_no')->nullable();
            $table->string('booking_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('logistics_id');
            $table->dropColumn('logistics_type');
            $table->dropColumn('logistics_sub_type');
            $table->dropColumn('cvs_payment_no');
            $table->dropColumn('cvs_validation_no');
            $table->dropColumn('booking_note');
        });
    }
};

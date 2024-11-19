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
            $table->enum('recipient_gender', ['1', '2'])->nullable()->comment('收件人性別')->change();
            $table->enum('receipt_type', ['2', '3'])->nullable()->comment('收據類型');
            $table->string('invoice_title')->nullable()->comment('發票抬頭');
            $table->string('invoice_number')->nullable()->comment('發票統編');
            $table->string('invoice_county')->nullable()->comment('發票縣市');
            $table->string('invoice_district')->nullable()->comment('發票區域');
            $table->string('invoice_address')->nullable()->comment('發票地址');
            $table->string('shipping_county')->nullable();
            $table->string('shipping_district')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('recipient_gender');
            $table->dropColumn('invoice_title');
            $table->dropColumn('invoice_number');
            $table->dropColumn('invoice_county');
            $table->dropColumn('invoice_district');
            $table->dropColumn('invoice_address');
            $table->dropColumn('shipping_county');
            $table->dropColumn('shipping_district');
            $table->dropColumn('shipping_address');
        });
    }
};

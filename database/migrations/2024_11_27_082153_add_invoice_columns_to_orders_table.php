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
            $table->string('issued_invoice_number')->nullable()->comment('開立發票號碼');
            $table->string('issued_invoice_date')->nullable()->comment('開立發票日期');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('issued_invoice_number');
            $table->dropColumn('issued_invoice_date');
        });
    }
};

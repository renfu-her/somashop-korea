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
            $driver = Schema::getConnection()->getDriverName();

            if ($driver === 'sqlite') {
                $table->dropForeign(['member_id']);
            } else {
                $table->dropForeign('orders_user_id_foreign');
                $table->dropIndex('orders_user_id_foreign');
            }

            $table->unsignedBigInteger('member_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('member_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};

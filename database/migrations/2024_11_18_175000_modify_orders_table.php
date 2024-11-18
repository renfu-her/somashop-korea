<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            // 收件人資訊
            $table->tinyInteger('recipient_gender')->nullable()->after('recipient_phone')->comment('收件人性別');
            $table->string('recipient_county')->nullable()->after('recipient_gender')->comment('縣市');
            $table->string('recipient_district')->nullable()->after('recipient_county')->comment('區域');
            $table->string('recipient_zipcode')->nullable()->after('recipient_district')->comment('郵遞區號');
            $table->string('recipient_address')->nullable()->after('recipient_zipcode')->comment('詳細地址');

            // 超商資訊
            $table->string('store_id')->nullable()->after('recipient_address')->comment('超商店號');
            $table->string('store_name')->nullable()->after('store_id')->comment('超商店名');
            $table->string('store_address')->nullable()->after('store_name')->comment('超商地址');

            // 發票資訊
            $table->string('invoice_type')->nullable()->after('store_address')->comment('發票類型');
            $table->string('tax_id')->nullable()->after('invoice_type')->comment('統一編號');
            $table->string('company_name')->nullable()->after('tax_id')->comment('公司抬頭');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'payment_status',
                'shipping_method',
                'shipping_status',
                'shipping_fee',
                'recipient_name',
                'recipient_phone',
                'recipient_gender',
                'recipient_county',
                'recipient_district',
                'recipient_zipcode',
                'recipient_address',
                'store_id',
                'store_name',
                'store_address',
                'invoice_type',
                'tax_id',
                'company_name',
                'note'
            ]);
        });
    }
};

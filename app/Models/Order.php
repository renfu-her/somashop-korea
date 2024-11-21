<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'order_id',
        'member_id',
        'total_amount',
        'status',
        // 付款相關
        'payment_method',
        'payment_status',
        // 運送相關
        'shipping_method',
        'shipping_status',
        'shipping_fee',
        'shipping_county',
        'shipping_district',
        'shipping_zipcode',
        // 收件人資訊
        'recipient_name',
        'recipient_phone',
        'recipient_gender',
        'recipient_county',
        'recipient_district',
        'recipient_zipcode',
        'recipient_address',
        // 超商資訊
        'store_id',
        'store_name',
        'store_address',
        // 發票資訊
        'invoice_type',
        'tax_id',
        'company_name',
        // 其他
        'note',
        'receipt_type',
        'invoice_title',
        'invoice_number',
        'invoice_county',
        'invoice_district',
        'invoice_address',
        'shipping_county',
        'shipping_district',
        'shipment_method',
        'logistics_id',
        'logistics_type',
        'logistics_sub_type',
        'cvs_payment_no',
        'cvs_validation_no',
        'booking_note',
        'paid_at',
        'payment_date',
        'trade_no',
        'payment_fee',
    ];

    protected $casts = [
        'total_amount' => 'decimal:0',
        'shipping_fee' => 'decimal:0',
        'recipient_gender' => 'integer'
    ];

    // 訂單狀態
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // 付款狀態
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_FAILED = 'failed';

    // 付款方式
    const PAYMENT_METHOD_CREDIT = 'credit';
    const PAYMENT_METHOD_ATM = 'atm';
    const PAYMENT_METHOD_TRANSFER = 'transfer';

    // 運送狀態
    const SHIPPING_STATUS_PENDING = 'pending';
    const SHIPPING_STATUS_SHIPPED = 'shipped';
    const SHIPPING_STATUS_DELIVERED = 'delivered';

    // 運送方式
    const SHIPPING_METHOD_MAIL = 'mail_send';
    const SHIPPING_METHOD_711 = '711_b2c';
    const SHIPPING_METHOD_FAMILY = 'family_b2c';

    // 發票類型
    const INVOICE_TYPE_PERSONAL = 'personal';
    const INVOICE_TYPE_COMPANY = 'company';
    const INVOICE_TYPE_DONATION = 'donation';    // 配送失敗
    const SHIPPING_STATUS_STORE_ARRIVED = 'store_arrived';  // 已送達門市
    const SHIPPING_STATUS_COMPLETED = 'completed'; 
    const SHIPPING_STATUS_PROCESSING = 'processing';

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // 取得狀態顯示文字
    public function getStatusTextAttribute()
    {
        return [
            self::STATUS_PENDING => '待處理',
            self::STATUS_PROCESSING => '處理中',
            self::STATUS_COMPLETED => '已完成',
            self::STATUS_CANCELLED => '已取消'
        ][$this->status] ?? '未知';
    }

    // 取得付款狀態顯示文字
    public function getPaymentStatusTextAttribute()
    {
        return [
            self::PAYMENT_STATUS_PENDING => '待付款',
            self::PAYMENT_STATUS_PAID => '已付款',
            self::PAYMENT_STATUS_FAILED => '付款失敗'
        ][$this->payment_status] ?? '未知';
    }

    // 取得運送狀態顯示文字
    public function getShippingStatusTextAttribute()
    {
        return [
            self::SHIPPING_STATUS_PENDING => '待出貨',
            self::SHIPPING_STATUS_SHIPPED => '已出貨',
            self::SHIPPING_STATUS_DELIVERED => '已送達',
            self::SHIPPING_STATUS_STORE_ARRIVED => '已送達門市',
            self::SHIPPING_STATUS_COMPLETED => '已完成',
            self::SHIPPING_STATUS_PROCESSING => '處理中'
        ][$this->shipping_status] ?? '未知';
    }
}

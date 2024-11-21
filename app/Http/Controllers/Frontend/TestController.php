<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MailService;
use App\Models\Member;
use App\Models\Order;
use App\Http\Controllers\Frontend\PaymentController;

class TestController extends Controller
{

    protected $captchaService;
    protected $mailService;
    protected $paymentController;
    protected $shipmentMerchantID;
    protected $shipmentHashKey;
    protected $shipmentHashIV;

    public function __construct(
        MailService $mailService,
        PaymentController $paymentController
    ) {
        $this->mailService = $mailService;
        $this->paymentController = $paymentController;

        $this->shipmentMerchantID = config('app.env') === 'production' ? config('config.ecpay_shipment_merchant_id') : config('config.ecpay_stage_shipment_merchant_id');
        $this->shipmentHashKey = config('app.env') === 'production' ? config('config.ecpay_shipment_hash_key') : config('config.ecpay_stage_shipment_hash_key');
        $this->shipmentHashIV = config('app.env') === 'production' ? config('config.ecpay_shipment_hash_iv') : config('config.ecpay_stage_shipment_hash_iv');
    
    }
    public function test(MailService $mailService)
    {

        $member = Member::where('email', 'renfu.her@gmail.com')->first();
        $this->mailService->send(
            $member->email,
            '歡迎加入會員',
            [
                'title' => '歡迎加入',
                'content' => "親愛的 {$member->name} 您好，\n\n感謝您加入我們的會員...",
                'button' => [
                    'text' => '購物網站，您可以開始購物了！',
                    'url' => route('home')
                ]
            ],
            'emails.content',
            ['member' => $member]
        );
    }

    public function testLogistics()
    {
        // 獲取測試訂單和會員
        $order = Order::where('order_number', 'OID202411200008')->first();
        $member = Member::find($order->member_id);

        if (!$order || !$member) {
            return response()->json([
                'success' => false,
                'message' => '找不到測試訂單或會員'
            ], 404);
        }


        // 使用注入的 PaymentController 實例呼叫方法
        $result = $this->paymentController->createLogisticsOrder($order, $member);

        dd($result);

        return response()->json([
            'success' => $result,
            'order' => $order->toArray(),
            'logistics_info' => [
                'logistics_id' => $order->logistics_id,
                'logistics_type' => $order->logistics_type,
                'logistics_sub_type' => $order->logistics_sub_type,
                'cvs_payment_no' => $order->cvs_payment_no,
                'cvs_validation_no' => $order->cvs_validation_no,
                'booking_note' => $order->booking_note
            ]
        ]);
    }

    public function testPaymentCheck()
    {
        $orders = Order::where('payment_status', 'paid')->get();
        foreach ($orders as $order) {
            if($order->shipping_status == Order::SHIPPING_STATUS_PROCESSING){
                if(!empty($order->logistics_id)){
                    // 檢查他的貨運狀態

                }
            }
        }
    }

    private function generateCheckMacValue($data)
    {
        // 按照綠界規範產生檢查碼
        ksort($data);
        $checkStr = "HashKey={$this->shipmentHashKey}";

        foreach ($data as $key => $value) {
            $checkStr .= "&{$key}={$value}";
        }

        $checkStr .= "&HashIV={$this->shipmentHashIV}";
        $checkStr = urlencode($checkStr);
        $checkStr = strtolower($checkStr);

        return strtoupper(hash('sha256', $checkStr));
    }
}

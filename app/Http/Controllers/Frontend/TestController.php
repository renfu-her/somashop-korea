<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MailService;
use App\Models\Member;
use App\Models\Order;
use App\Http\Controllers\Frontend\PaymentController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class TestController extends Controller
{

    protected $captchaService;
    protected $mailService;
    protected $paymentController;
    protected $shipmentMerchantID;
    protected $shipmentHashKey;
    protected $shipmentHashIV;
    protected $merchantID;
    protected $hashKey;
    protected $hashIV;

    public function __construct(
        MailService $mailService,
        PaymentController $paymentController
    ) {
        $this->mailService = $mailService;
        $this->paymentController = $paymentController;

        $this->merchantID = config('app.env') === 'production' ? config('config.ecpay_merchant_id') : config('config.ecpay_stage_merchant_id');
        $this->hashKey = config('app.env') === 'production' ? config('config.ecpay_hash_key') : config('config.ecpay_stage_hash_key');
        $this->hashIV = config('app.env') === 'production' ? config('config.ecpay_hash_iv') : config('config.ecpay_stage_hash_iv');


        $this->shipmentMerchantID = config('app.env') === 'production' ? config('config.ecpay_shipment_merchant_id') : config('config.ecpay_stage_shipment_merchant_id');
        $this->shipmentHashKey = config('app.env') === 'production' ? config('config.ecpay_shipment_hash_key') : config('config.ecpay_stage_shipment_hash_key');
        $this->shipmentHashIV = config('app.env') === 'production' ? config('config.ecpay_shipment_hash_iv') : config('config.ecpay_stage_shipment_hash_iv');
    }
    
    public function testMail(MailService $mailService)
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

    public function updateShippingStatus(Request $request)
    {

        set_time_limit(0);

        // 獲取所有未付款的 ATM 訂單
        $orders = Order::where('payment_method', 'atm')
            ->where('payment_status', 'pending')
            ->get();

        foreach ($orders as $order) {
            sleep(1);
            $response = $this->queryECPayOrder($order);

            if (!empty($response) && $response['TradeStatus'] === '1') {
                // 更新訂單狀態為已付款
                $order->update([
                    'payment_status' => 'paid',
                    'paid_at' => $response['PaymentDate'],
                ]);

                Log::info("ATM 訂單 {$order->order_number} 已完成付款", [
                    'payment_date' => $response['PaymentDate']
                ]);
            }
        }
    }

    protected function queryECPayOrder(Order $order)
    {
        $postData = [
            'MerchantID' => $this->merchantID,
            'MerchantTradeNo' => $order->order_number,
            'TimeStamp' => time(),
        ];

        // 加入檢查碼
        $postData['CheckMacValue'] = $this->generateCheckMacValue($postData);

        $api_url = config('app.env') === 'production'
            ? 'https://payment.ecpay.com.tw/Cashier/QueryTradeInfo/V5'
            : 'https://payment-stage.ecpay.com.tw/Cashier/QueryTradeInfo/V5';


        $response = Http::asForm()
            ->post($api_url, $postData);

        if ($response->status() === 200) {
            parse_str($response->body(), $responseData);

            if ($responseData['TradeStatus'] === '1') {
                Log::info("ATM 訂單 {$order->order_number} 已完成付款", [
                    'payment_date' => $responseData['PaymentDate']
                ]);
                $order->payment_status = 'paid';
                $order->payment_date = $responseData['PaymentDate'];
                $order->save();

                return $responseData;
            }

            Log::error("ATM 查詢訂單 {$order->order_number} 發生錯誤", [
                'error' => $response
            ]);
        }
        return null;
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

        return strtoupper(md5($checkStr));
    }

    private function updateOrderShippingStatus($order, $logisticsStatus)
    {
        // 參考綠界物流狀態代碼：https://developers.ecpay.com.tw/?p=7418
        switch ($logisticsStatus) {
            case '300':  // 訂單建立
                $order->shipping_status = Order::SHIPPING_STATUS_PROCESSING;
                break;

            case '2063': // 退貨完成
                $order->shipping_status = Order::SHIPPING_STATUS_RETURNED;
                break;

            case '3001': // 貨物已到達門市
            case '3002': // 貨物已到達門市（退貨）
                $order->shipping_status = Order::SHIPPING_STATUS_ARRIVED_STORE;
                break;

            case '2030': // 貨物已送達
            case '3003': // 貨物已取貨
                $order->shipping_status = Order::SHIPPING_STATUS_DELIVERED;
                break;

            case '2067': // 門市關轉
            case '2068': // 門市倒閉
                $order->shipping_status = Order::SHIPPING_STATUS_STORE_CLOSED;
                // 可以在這裡添加通知管理員的邏輯
                break;

            case '2065': // 退貨中
                $order->shipping_status = Order::SHIPPING_STATUS_RETURNING;
                break;

            case '2066': // 拒收
                $order->shipping_status = Order::SHIPPING_STATUS_REJECTED;
                break;

            default:
                // 記錄未處理的狀態碼
                Log::info('未處理的物流狀態碼：' . $logisticsStatus, [
                    'order_id' => $order->id,
                    'logistics_id' => $order->logistics_id
                ]);
                return;
        }

        $order->shipping_status = $logisticsStatus;
        $order->save();
    }
}

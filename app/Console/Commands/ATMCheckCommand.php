<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ATMCheckCommand extends Command
{
    protected $signature = 'order:check-atm-payment';
    protected $description = '檢查 ATM 付款狀態';
    protected $merchantID;
    protected $hashKey;
    protected $hashIV;


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $this->merchantID = config('app.env') === 'production' ? config('config.ecpay_merchant_id') : config('config.ecpay_stage_merchant_id');
        $this->hashKey = config('app.env') === 'production' ? config('config.ecpay_hash_key') : config('config.ecpay_stage_hash_key');
        $this->hashIV = config('app.env') === 'production' ? config('config.ecpay_hash_iv') : config('config.ecpay_stage_hash_iv');


        // 獲取所有未付款的 ATM 訂單
        $orders = Order::where('payment_method', 'atm')
            ->where('payment_status', 'pending')
            ->get();

        foreach ($orders as $order) {
            try {
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
            } catch (\Exception $e) {
                Log::error("查詢 ATM 訂單 {$order->order_number} 發生錯誤", [
                    'error' => $e->getMessage()
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
            ->post($api_url, $postData)
            ->json();

        if ($response['TradeStatus'] === '1') {
            Log::info("ATM 訂單 {$order->order_number} 已完成付款", [
                'payment_date' => $response['PaymentDate']
            ]);
            $order->payment_status = 'paid';
            $order->payment_date = $response['PaymentDate'];
            $order->save();

            return $response;
        }

        Log::error("ATM 查詢訂單 {$order->order_number} 發生錯誤", [
            'error' => $response
        ]);

        return null;
    }

    private function generateCheckMacValue($data)
    {
        // 按照綠界規範產生檢查碼
        ksort($data);
        $checkStr = "HashKey={$this->hashKey}";

        foreach ($data as $key => $value) {
            $checkStr .= "&{$key}={$value}";
        }

        $checkStr .= "&HashIV={$this->hashIV}";
        $checkStr = urlencode($checkStr);
        $checkStr = strtolower($checkStr);

        return strtoupper(md5($checkStr));
    }

    protected function verifyCheckMacValue(array $response): bool
    {
        // 實作綠界的檢查碼驗證邏輯
        return true;
    }
}

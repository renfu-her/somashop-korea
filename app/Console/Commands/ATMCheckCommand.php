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

        $this->merchantID = config('config.app_run') === 'production' ? config('config.ecpay_merchant_id') : config('config.ecpay_stage_merchant_id');
        $this->hashKey = config('config.app_run') === 'production' ? config('config.ecpay_hash_key') : config('config.ecpay_stage_hash_key');
        $this->hashIV = config('config.app_run') === 'production' ? config('config.ecpay_hash_iv') : config('config.ecpay_stage_hash_iv');


        // 獲取所有未付款的 ATM 訂單
        $orders = Order::where('payment_method', 'atm')
            ->where('payment_status', 'pending')
            ->get();

        foreach ($orders as $order) {

            $response = $this->queryECPayOrder($order);

            if (!empty($response) && !empty($response['TradeDate'])) {
                // 更新訂單狀態為已付款
                // $order->update([
                //     'payment_status' => 'paid',
                // ]);

                Log::info("ATM 訂單 {$order->order_number} 已完成付款", [
                    'RtnCode' => $response['RtnCode'],
                    'RtnMsg' => $response['RtnMsg'],
                    'TradeNo' => $response['TradeNo'],
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

        $api_url = config('config.app_run') === 'production'
            ? 'https://payment.ecpay.com.tw//Cashier/QueryPaymentInfo'
            : 'https://payment-stage.ecpay.com.tw/Cashier/QueryPaymentInfo';


        $response = Http::asForm()
            ->post($api_url, $postData);

        parse_str($response->body(), $result);

        // dd($result);

        if (!empty($result['TradeNo'])) {
            Log::info("ATM 訂單 {$order->order_number} 已完成取號", [
                'RtnCode' => $result['RtnCode'],
                'RtnMsg' => $result['RtnMsg'],
                'TradeNo' => $result['TradeNo'],
            ]);
            // $order->payment_status = 'paid';
            // $order->payment_date = $result['PaymentDate'];
            // $order->save();

            return $result;
        }

        Log::error("ATM 查詢訂單 {$order->order_number} 發生錯誤", [
            'error' => $result
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

        return strtoupper(hash('sha256', $checkStr));
    }

    protected function verifyCheckMacValue(array $response): bool
    {
        // 實作綠界的檢查碼驗證邏輯
        return true;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class CheckLogisticsStatus extends Command
{
    protected $signature = 'logistics:check {order_id?}';
    protected $description = '查詢綠界物流訂單狀態';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        $orders = $orderId ? Order::where('id', $orderId)->get() : Order::where('payment_method', 'COD')->get();

        foreach ($orders as $order) {
            $this->info("正在查詢訂單 {$order->order_number} 的物流狀態...");

            $params = [
                'MerchantID' => config('app.env') === 'production' ? config('config.ecpay_merchant_id') : config('config.ecpay_stage_merchant_id'),
                'MerchantTradeNo' => $order->order_number,
                'TimeStamp' => time(),
                'CheckMacValue' => $this->generateCheckMacValue([
                    'MerchantID' => config('app.env') === 'production' ? config('config.ecpay_merchant_id') : config('config.ecpay_stage_merchant_id'),
                    'MerchantTradeNo' => $order->order_number,
                    'TimeStamp' => time(),
                ])
            ];

            $apiUrl = config('app.env') === 'production'
                ? 'https://logistics.ecpay.com.tw/Helper/QueryLogisticsTradeInfo/V5'
                : 'https://logistics-stage.ecpay.com.tw/Helper/QueryLogisticsTradeInfo/V5';

            try {
                $response = Http::asForm()->post($apiUrl, $params);
                $result = $this->parseResponse($response->body());

                $this->info("訂單狀態：{$result['LogisticsStatus']}");
                $this->info("物流方式：{$result['LogisticsType']}");
                $this->info("代收金額：{$result['CollectionAmount']}");
                $this->info("物流費用：{$result['HandlingCharge']}");
                $this->info("配送編號：{$result['ShipmentNo']}");
                $this->info("訂單成立時間：{$result['TradeDate']}");
                $this->info("----------------------------------------");

                // 記錄到日誌
                Log::info("物流查詢結果", [
                    'order_number' => $order->order_number,
                    'result' => $result
                ]);

            } catch (\Exception $e) {
                $this->error("查詢失敗：" . $e->getMessage());
                Log::error("物流查詢失敗", [
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    private function parseResponse($response)
    {
        $result = [];
        parse_str($response, $result);
        return $result;
    }

    private function generateCheckMacValue($params)
    {
        $hashKey = config('app.env') === 'production' ? config('config.ecpay_hash_key') : config('config.ecpay_stage_hash_key');
        $hashIV = config('app.env') === 'production' ? config('config.ecpay_hash_iv') : config('config.ecpay_stage_hash_iv');

        // 1. 參數依照字母順序排序
        ksort($params);

        // 2. 組合參數字串
        $queryString = http_build_query($params);

        // 3. 加入 HashKey 和 HashIV
        $queryString = "HashKey={$hashKey}&{$queryString}&HashIV={$hashIV}";

        // 4. URL encode
        $queryString = urlencode($queryString);

        // 5. 轉小寫
        $queryString = strtolower($queryString);

        // 6. 產生 SHA256 雜湊值
        $checkMacValue = hash('sha256', $queryString);

        // 7. 轉大寫
        return strtoupper($checkMacValue);
    }
} 
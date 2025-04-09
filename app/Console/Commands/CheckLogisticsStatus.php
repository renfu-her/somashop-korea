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
    protected $shipmentMerchantID;
    protected $shipmentHashKey;
    protected $shipmentHashIV;

    public function __construct()
    {
        parent::__construct();
        $this->shipmentMerchantID = config('config.app_run') === 'production' ? config('config.ecpay_shipment_merchant_id') : config('config.ecpay_stage_shipment_merchant_id');
        $this->shipmentHashKey = config('config.app_run') === 'production' ? config('config.ecpay_shipment_hash_key') : config('config.ecpay_stage_shipment_hash_key');
        $this->shipmentHashIV = config('config.app_run') === 'production' ? config('config.ecpay_shipment_hash_iv') : config('config.ecpay_stage_shipment_hash_iv');
    }

    public function handle()
    {
        $orderId = $this->argument('order_id');
        $orders = $orderId ?
            Order::where('id', $orderId)->get() :
            Order::where(
                'shipping_status',
                Order::SHIPPING_STATUS_PROCESSING
            )->where('payment_method', 'COD')->get();

        foreach ($orders as $order) {
            $this->info("正在查詢訂單 {$order->order_number} 的物流狀態...");

            $params = [
                'MerchantID' => $this->shipmentMerchantID,
                'MerchantTradeNo' => $order->order_number,
                'TimeStamp' => time(),
            ];

            $params['CheckMacValue'] = $this->generateCheckMacValue($params);

            $apiUrl = config('config.app_run') === 'production'
                ? 'https://logistics.ecpay.com.tw/Helper/QueryLogisticsTradeInfo/V5'
                : 'https://logistics-stage.ecpay.com.tw/Helper/QueryLogisticsTradeInfo/V5';

            try {
                $response = Http::asForm()->post($apiUrl, $params);

                // 檢查回應是否為空
                if (empty($response->body())) {
                    $this->error("回應為空");
                    continue;
                }

                $result = $this->parseResponse($response->body());

                // 檢查是否有錯誤訊息
                if (isset($result['RtnCode']) && $result['RtnCode'] !== '1') {
                    // $this->error("查詢失敗：{$result['RtnMsg']}");
                    $this->info("完整回應：" . print_r($result, true));
                    continue;
                }

                $this->info("訂單狀態：{$result['LogisticsStatus']}");
                $this->info("物流方式：{$result['LogisticsType']}");
                $this->info("代收金額：{$result['CollectionAmount']}");
                $this->info("----------------------------------------");

                $this->updateOrderShippingStatus($order, $result['LogisticsStatus']);

                // 記錄到日誌
                Log::info("物流查詢結果", [
                    'order_number' => $order->order_number,
                    'result' => $result
                ]);
            } catch (\Exception $e) {
                $this->error("查詢失敗：" . $e->getMessage());
                Log::error("物流查詢失敗", [
                    'order_number' => $order->order_number,
                    'error' => $e->getMessage(),
                    'response' => $response->body() ?? '無回應內容'
                ]);
            }
        }
    }

    private function parseResponse($response)
    {
        $result = [];
        parse_str($response, $result);

        // 如果解析結果為空，記錄原始回應
        if (empty($result)) {
            Log::error("回應解析失敗", [
                'original_response' => $response
            ]);
        }

        return $result;
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
        // 參考綠界物流狀態代碼：https://developers.ecpay.com.tw/?p=7420
        switch ($logisticsStatus) {
            // 商品已送至物流中心
            case '2030': // 7-11 B2C, 7-11 C2C, OK C2C
            case '3024': // 全家 B2C, 全家 C2C, 萊爾富 B2C, 萊爾富 C2C
                $order->shipping_status = Order::SHIPPING_STATUS_PROCESSING;
                break;

            // 商品已送達門市
            case '2063': // 7-11 B2C
            case '2073': // 7-11 C2C, OK C2C
            case '3018': // 全家 B2C, 全家 C2C, 萊爾富 B2C, 萊爾富 C2C
                $order->shipping_status = Order::SHIPPING_STATUS_ARRIVED_STORE;
                break;

            // 消費者成功取件
            case '2067': // 7-11 B2C, 7-11 C2C
            case '3022': // 全家 B2C, 全家 C2C, 萊爾富 B2C, 萊爾富 C2C, OK C2C
                $order->shipping_status = Order::SHIPPING_STATUS_DELIVERED;
                break;

            // 消費者七天未取件
            case '2074': // 7-11 B2C, 7-11 C2C, OK C2C
            case '3020': // 全家 B2C, 全家 C2C, 萊爾富 B2C, 萊爾富 C2C
                $order->shipping_status = Order::SHIPPING_STATUS_EXPIRED;
                break;

            case '300':
                $order->shipping_status = Order::SHIPPING_STATUS_PROCESSING;
                break;

            default:
                // 記錄未處理的狀態碼
                Log::info('未處理的物流狀態碼：' . $logisticsStatus, [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'logistics_type' => $order->logistics_type
                ]);
                return;
        }

        $order->save();

        // 記錄狀態更新
        Log::info('訂單物流狀態已更新', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'old_status' => $order->getOriginal('shipping_status'),
            'new_status' => $order->shipping_status,
            'logistics_status' => $logisticsStatus
        ]);
    }
}

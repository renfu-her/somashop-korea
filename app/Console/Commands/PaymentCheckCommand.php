<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class PaymentCheckCommand extends Command
{
    protected $signature = 'app:payment-check-command';
    protected $description = '結帳出貨檢查';
    protected $shipmentMerchantID;
    protected $shipmentHashKey;
    protected $shipmentHashIV;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->shipmentMerchantID = config('config.app_run') === 'production' ? config('config.ecpay_shipment_merchant_id') : config('config.ecpay_stage_shipment_merchant_id');
        $this->shipmentHashKey = config('config.app_run') === 'production' ? config('config.ecpay_shipment_hash_key') : config('config.ecpay_stage_shipment_hash_key');
        $this->shipmentHashIV = config('config.app_run') === 'production' ? config('config.ecpay_shipment_hash_iv') : config('config.ecpay_stage_shipment_hash_iv');

        set_time_limit(0);

        $orders = Order::where(
            'shipping_status',
            Order::SHIPPING_STATUS_PROCESSING
        )
            ->where('logistics_id', '!=', null)
            ->get();

        foreach ($orders as $order) {
            sleep(1);
            if ($order->shipping_status == Order::SHIPPING_STATUS_PROCESSING && !empty($order->logistics_id)) {
                // 準備查詢物流訂單的參數
                $data = [
                    'MerchantID' => $this->shipmentMerchantID,
                    'AllPayLogisticsID' => $order->logistics_id,
                    'TimeStamp' => time(),
                ];

                // 加入檢查碼
                $data['CheckMacValue'] = $this->generateCheckMacValue($data);

                // 使用 Http::post 發送請求
                $api_url = config('app.env') === 'production'
                    ? 'https://logistics.ecpay.com.tw/Helper/QueryLogisticsTradeInfo/V4'
                    : 'https://logistics-stage.ecpay.com.tw/Helper/QueryLogisticsTradeInfo/V4';

                $response = Http::asForm()
                    ->post($api_url, $data);


                // 解析回應
                parse_str($response->body(), $result);

                if (isset($result['LogisticsStatus'])) {
                    Log::info('更新訂單物流狀態', [
                        'order_id' => $order->id,
                        'logistics_id' => $order->logistics_id,
                        'logistics_status' => $result['LogisticsStatus']
                    ]);
                    $this->updateOrderShippingStatus($order, $result['LogisticsStatus']);
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

        $order->save();
    }
}

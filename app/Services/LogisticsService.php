<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Member;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LogisticsService
{
    private $merchantID;
    private $hashKey;
    private $hashIV;

    public function __construct()
    {
        $this->merchantID = config('app.env') === 'production' ? config('config.ecpay_shipment_merchant_id') : config('config.ecpay_stage_shipment_merchant_id');
        $this->hashKey = config('app.env') === 'production' ? config('config.ecpay_shipment_hash_key') : config('config.ecpay_stage_shipment_hash_key');
        $this->hashIV = config('app.env') === 'production' ? config('config.ecpay_shipment_hash_iv') : config('config.ecpay_stage_shipment_hash_iv');
    }

    public function createLogisticsOrder(Order $order, Member $member, $paymentType = null)
    {
        // 准备物流 API 需要的资料
        $logisticsData = [
            'MerchantID' => $this->merchantID,
            'MerchantTradeNo' => $order->order_number,
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'LogisticsType' => 'CVS',
            'LogisticsSubType' => $this->getLogisticsSubType($order->shipment_method),
            'GoodsAmount' => $order->total_amount,
            'CollectionAmount' => 0,
            'IsCollection' => $paymentType == 'COD' ? 'Y' : 'N',
            'GoodsName' => '商品一批',
            'SenderName' => $order->store_name,
            'SenderPhone' => $order->store_telephone,
            'ReceiverName' => $order->recipient_name,
            'ReceiverPhone' => $order->recipient_phone,
            'ReceiverCellPhone' => $order->recipient_phone,
            'ReceiverEmail' => $member->email,
            'TradeDesc' => '商品配送',
            'ServerReplyURL' => route('logistics.notify'),
            'LogisticsC2CReplyURL' => route('logistics.store.notify'),
            'Remark' => $order->note ?? '',
        ];

        if ($order->store_id) {
            $logisticsData['ReceiverStoreID'] = $order->store_id;
        }

        $logisticsData['CheckMacValue'] = $this->generateCheckMacValue($logisticsData);

        Log::info('建立物流訂單', [
            'logistics_data' => $logisticsData
        ]);

        // try {
        $response = Http::asForm()->post(
            config('app.env') === 'production'
                ? 'https://logistics.ecpay.com.tw/Express/Create'
                : 'https://logistics-stage.ecpay.com.tw/Express/Create',
            $logisticsData
        );

        $result = [];
        $rtnCode = 0;
        $responseBody = $response->body();

        Log::info('建立物流訂單回應', [
            'response_body' => $responseBody
        ]);

        if (strpos($responseBody, '1|') === 0) {
            $rtnCode = 1;
            $data = substr($responseBody, 2);
            parse_str($data, $parsedData);
            $result = array_merge(['RtnCode' => 300], $parsedData);
        } else {
            $result = [
                'RtnCode' => 0,
                'RtnMsg' => substr($responseBody, 2)
            ];
        }

        if ($rtnCode == 1) {
            $order->update([
                'shipping_status' => Order::SHIPPING_STATUS_PROCESSING,
                'logistics_id' => $result['AllPayLogisticsID'] ?? null,
                'logistics_type' => $result['LogisticsType'] ?? null,
                'logistics_sub_type' => $result['LogisticsSubType'] ?? null,
                'cvs_payment_no' => $result['CVSPaymentNo'] ?? null,
                'cvs_validation_no' => $result['CVSValidationNo'] ?? null,
                'booking_note' => $result['BookingNote'] ?? null
            ]);

            Log::info('物流訂單建立成功', [
                'order_number' => $order->order_number,
                'logistics_result' => $result
            ]);

            return true;
        }

        Log::error('物流訂單建立失敗', [
            'order_number' => $order->order_number,
            'logistics_result' => $result
        ]);
        return false;

        // } catch (\Exception $e) {
        //     Log::error('物流訂單建立異常', [
        //         'order_number' => $order->order_number,
        //         'error' => $e->getMessage()
        //     ]);
        //     return false;
        // }
    }

    private function getLogisticsSubType($shipment)
    {
        switch ($shipment) {
            case '711_b2c':
                return 'UNIMARTC2C';
            case 'family_b2c':
                return 'FAMIC2C';
            default:
                return 'UNIMARTC2C';
        }
    }

    private function generateCheckMacValue($data)
    {
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
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Models\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    private $paymentService;

    private $merchantID;
    private $hashKey;
    private $hashIV;

    private $shipmentMerchantID;
    private $shipmentHashKey;
    private $shipmentHashIV;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;

        $this->merchantID = config('app.env') === 'production' ? config('config.ecpay_merchant_id') : config('config.ecpay_stage_merchant_id');
        $this->hashKey = config('app.env') === 'production' ? config('config.ecpay_hash_key') : config('config.ecpay_stage_hash_key');
        $this->hashIV = config('app.env') === 'production' ? config('config.ecpay_hash_iv') : config('config.ecpay_stage_hash_iv');

        $this->shipmentMerchantID = config('app.env') === 'production' ? config('config.ecpay_shipment_merchant_id') : config('config.ecpay_stage_shipment_merchant_id');
        $this->shipmentHashKey = config('app.env') === 'production' ? config('config.ecpay_shipment_hash_key') : config('config.ecpay_stage_shipment_hash_key');
        $this->shipmentHashIV = config('app.env') === 'production' ? config('config.ecpay_shipment_hash_iv') : config('config.ecpay_stage_shipment_hash_iv');
    
    }

    public function paymentProcess(Request $request)
    {
        return $this->paymentService->paymentProcess($request);
    }

    // 接收綠界支付通知
    public function notify(Request $request)
    {
        $data = $request->all();

        // 檢查檢查碼
        if ($this->paymentCheckMacValue($data)) {
            $order = Order::where('order_number', $data['MerchantTradeNo'])->first();

            if ($order && $data['RtnCode'] == 1) {
                $order->payment_status = Order::PAYMENT_STATUS_PAID;
                $order->status = Order::STATUS_PROCESSING;
                $order->save();
            }

            return '1|OK';
        }

        return '0|FAIL';
    }

    // 支付完成頁面
    public function result(Request $request)
    {
        $data = $request->all();

        if ($this->paymentCheckMacValue($data)) {
            return view('frontend.payment.complete', [
                'success' => ($data['RtnCode'] == 1),
                'message' => $data['RtnMsg'],
                'orderNumber' => $data['MerchantTradeNo']
            ]);
        }

        return redirect()->route('index')->with('error', '付款驗證失敗');
    }

    // 付款結果
    public function paymentCallback(Request $request)
    {
        $paymentResult = $request->all();

        // 根據訂單編號查詢訂單
        $order = Order::where('order_number', $paymentResult['MerchantTradeNo'])->first();
        $orderItems = OrderItem::with(['product', 'productImage'])->where('order_id', $order->id)->get();
        $shippingFee = Setting::where('key', 'shipping_fee')->first()->value;
        $totalAmount = $order->total_amount;
        $member = Member::find($order->member_id);

        // 更新訂單付款狀態
        if ($paymentResult['RtnCode'] === '1') {
            $order->update([
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'status' => Order::STATUS_PROCESSING,
                'payment_method' => $this->mapPaymentType($paymentResult['PaymentType']),
                'payment_date' => $paymentResult['PaymentDate'],
                'trade_no' => $paymentResult['TradeNo'],
                'payment_fee' => $paymentResult['PaymentTypeChargeFee']
            ]);

            // 物流方式 API
            if ($order->shipment_method != 'mail_send') {
                $this->createLogisticsOrder($order, $member);
            }

            // 發票 API
            if ($order->receipt_type == '3') {
                $order->update([
                    'invoice_number' => $paymentResult['InvoiceNumber']
                ]);
            }

            // 記錄付款成功日誌
            Log::info('付款成功', [
                'order_number' => $order->order_number,
                'payment_result' => $paymentResult
            ]);
        } else {
            $order->update([
                'payment_status' => Order::PAYMENT_STATUS_FAILED,
                'status' => Order::STATUS_CANCELLED
            ]);

            // 記錄付款失敗日誌
            Log::error('付款失敗', [
                'order_number' => $order->order_number,
                'payment_result' => $paymentResult
            ]);
        }

        return view('frontend.payment.complete', [
            'success' => ($paymentResult['RtnCode'] == 1),
            'message' => $paymentResult['RtnMsg'],
            'orderNumber' => $paymentResult['MerchantTradeNo'],
            'paymentMethod' => $this->mapPaymentType($paymentResult['PaymentType']),
            'order' => $order,
            'orderItems' => $orderItems,
            'shippingFee' => $shippingFee,
            'totalAmount' => $totalAmount,
            'member' => $member
        ]);
    }

    // 對應綠界支付方式到系統支付方式
    private function mapPaymentType($ecpayPaymentType)
    {
        switch ($ecpayPaymentType) {
            case 'Credit_CreditCard':
                return Order::PAYMENT_METHOD_CREDIT;
            case 'WebATM_TAISHIN':
            case 'WebATM_ESUN':
            case 'WebATM_BOT':
            case 'WebATM_FUBON':
            case 'WebATM_CHINATRUST':
            case 'WebATM_FIRST':
            case 'WebATM_CATHAY':
            case 'WebATM_MEGA':
            case 'WebATM_LAND':
            case 'WebATM_TACHONG':
            case 'WebATM_SINOPAC':
                return Order::PAYMENT_METHOD_ATM;
            default:
                return $ecpayPaymentType;
        }
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

    private function generateShipmentCheckMacValue($data)
    {
        // 排序參數
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

    private function paymentCheckMacValue($data)
    {
        $checkMacValue = $data['CheckMacValue'];
        unset($data['CheckMacValue']);

        return $this->generateCheckMacValue($data) === $checkMacValue;
    }

    // 新增物流相關的輔助方法
    private function getLogisticsSubType($shipment)
    {
        switch ($shipment) {
            case 'seven':
                return 'UNIMART'; // 7-11 B2C
            case 'family':
                return 'FAMI';    // 全家 B2C 
            case 'hilife':
                return 'HILIFE';  // 萊爾富 B2C
            default:
                return 'UNIMART';
        }
    }

    // 物流狀態通知
    public function logisticsNotify(Request $request)
    {
        $data = $request->all();

        if ($this->checkMacValue($data)) {
            $order = Order::where('order_number', $data['MerchantTradeNo'])->first();

            if ($order) {
                // 更新訂單物流狀態
                $order->shipping_status = $this->mapLogisticsStatus($data['RtnCode']);
                $order->save();

                Log::info('物流狀態更新', [
                    'order_number' => $order->order_number,
                    'status' => $data['RtnCode'],
                    'message' => $data['RtnMsg']
                ]);
            }

            return '1|OK';
        }

        return '0|FAIL';
    }

    private function mapLogisticsStatus($rtnCode)
    {
        switch ($rtnCode) {
            case 300: // 訂單建立成功
                return Order::SHIPPING_STATUS_PENDING;
            case 2030: // 商品已送達門市
                return Order::SHIPPING_STATUS_STORE_ARRIVED;
            case 3018: // 消費者取貨完成
                return Order::SHIPPING_STATUS_COMPLETED;
            default:
                return Order::SHIPPING_STATUS_PROCESSING;
        }
    }

    public function createLogisticsOrder($order, $member)
    {
        // 準備物流 API 需要的資料
        $logisticsData = [
            'MerchantID' => $this->shipmentMerchantID,
            'MerchantTradeNo' => $order->order_number,
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'LogisticsType' => 'CVS',
            'LogisticsSubType' => $this->getLogisticsSubType($order->shipment_method),
            'GoodsAmount' => $order->total_amount,
            'CollectionAmount' => 0,
            'IsCollection' => 'N',
            'GoodsName' => '商品一批',
            'SenderName' => $order->store_name,
            'SenderPhone' => $order->store_telephone,
            'SenderCellPhone' => $order->store_telephone,
            'ReceiverName' => $order->recipient_name,
            'ReceiverPhone' => $order->recipient_phone,
            'ReceiverCellPhone' => $order->recipient_phone,
            'ReceiverEmail' => $member->email,
            'TradeDesc' => '商品配送',
            'ServerReplyURL' => route('logistics.notify'),
            'LogisticsC2CReplyURL' => route('logistics.store.notify'),
            'Remark' => $order->note ?? '',
        ];

        // 如果是超商取貨，加入商店資訊
        if ($order->store_id) {
            $logisticsData['ReceiverStoreID'] = $order->store_id;
        }

        // 加入檢查碼
        $logisticsData['CheckMacValue'] = $this->generateShipmentCheckMacValue($logisticsData);

        // 使用 Laravel HTTP 客戶端發送請求
        $response = Http::asForm()->post(
            config('app.env') === 'production'
                ? 'https://logistics.ecpay.com.tw/Express/Create'
                : 'https://logistics-stage.ecpay.com.tw/Express/Create',
            $logisticsData
        );

        $result = [];
        $rtnCode = 0;
        $responseBody = $response->body();

        
        // 解析回傳資料
        if (strpos($responseBody, '1|') === 0) {
            // 成功
            $rtnCode = 1;
            $data = substr($responseBody, 2);
            parse_str($data, $parsedData);
            $result = array_merge(['RtnCode' => 300], $parsedData);
        } else {
            // 失敗 
            $result = [
                'RtnCode' => 0,
                'RtnMsg' => substr($responseBody, 2)
            ];
        }

        if ($rtnCode == 1) {
            // 更新訂單物流資訊
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
    }
}

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
use App\Services\LogisticsService;
use App\Services\MailService;

class PaymentController extends Controller
{
    private $paymentService;
    private $logisticsService;
    private $mailService;

    private $merchantID;
    private $hashKey;
    private $hashIV;

    private $shipmentMerchantID;
    private $shipmentHashKey;
    private $shipmentHashIV;

    public function __construct(
        PaymentService $paymentService,
        LogisticsService $logisticsService,
        MailService $mailService
    ) {
        $this->paymentService = $paymentService;
        $this->logisticsService = $logisticsService;
        $this->mailService = $mailService;

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
        Log::info('綠界支付通知', $data);


        // 檢查檢查碼
        if ($this->paymentCheckMacValue($data)) {
            Log::info('綠界檢查碼', $data['MerchantTradeNo']);
            $order = Order::where('order_number', $data['MerchantTradeNo'])->first();

            if ($order && $data['RtnCode'] == 1) {
                $order->update([
                    'payment_status' => Order::PAYMENT_STATUS_PAID,
                    'status' => Order::STATUS_PROCESSING,
                    // 'payment_method' => $this->mapPaymentType($data['PaymentType']),
                    'payment_date' => $data['PaymentDate'],
                    'trade_no' => $data['TradeNo'],
                    'payment_fee' => $data['PaymentTypeChargeFee']
                ]);

                // 發送訂單完成郵件
                // $this->sendOrderCompleteEmail($order, $data['PaymentType']);

                // 記錄付款成功日誌
                Log::info('付款成功', [
                    'order_number' => $order->order_number,
                    'payment_type' => $data['PaymentType'],
                    'trade_no' => $data['TradeNo']
                ]);

                return '1|OK';
            }
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
        switch ($order->shipment_method) {
            case 'mail_send':
                $shippingFee = Setting::where('key', 'shipping_fee')->first()->value;
                break;
            case '711_b2c':
                $shippingFee = Setting::where('key', '711_shipping_fee')->first()->value;
                break;
            case 'family_b2c':
                $shippingFee = Setting::where('key', 'family_shipping_fee')->first()->value;
                break;
            default:
                $shippingFee = 0;
                break;
        }
        $orderItems = OrderItem::with(['product', 'productImage'])->where('order_id', $order->id)->get();
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
                'payment_fee' => $paymentResult['PaymentTypeChargeFee'],
                'shipping_fee' => $shippingFee
            ]);

            $this->sendOrderCompleteEmail($order);

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

    public function paymentATMCallback(Request $request)
    {

        return redirect()->route('home');
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


    private function paymentCheckMacValue($data)
    {
        $checkMacValue = $data['CheckMacValue'];
        unset($data['CheckMacValue']);

        return $this->generateCheckMacValue($data) === $checkMacValue;
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

    public function sendOrderCompleteEmail(Order $order, $shipmentMethod = 'Credit')
    {
        $member = Member::find($order->member_id);

        // 獲取訂單項目並加載關聯數據
        $orderItems = OrderItem::with([
            'product',
            'spec',
            'product.images' => function ($query) {
                $query->where('is_primary', 1);
            }
        ])->where('order_id', $order->id)->get();

        $this->mailService->send(
            $member->email,
            '訂單完成通知',
            [
                'title' => '訂單完成通知',
                'content' => "親愛的 {$order->recipient_name} 您好，\n\n您的訂單已完成...",
                'button' => [
                    'text' => '查看訂單詳情',
                    'url' => route('orders.list')
                ]
            ],
            'emails.order-complete',
            [
                'order' => $order,
                'shipmentMethod' => $shipmentMethod,
                'orderItems' => $orderItems
            ]
        );
    }
}

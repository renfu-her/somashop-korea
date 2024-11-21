<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Member;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentService
{
    private $merchantID;
    private $hashKey;
    private $hashIV;

    public function __construct(LogisticsService $logisticsService)
    {
        $this->merchantID = config('app.env') === 'production' ? config('config.ecpay_merchant_id') : config('config.ecpay_stage_merchant_id');
        $this->hashKey = config('app.env') === 'production' ? config('config.ecpay_hash_key') : config('config.ecpay_stage_hash_key');
        $this->hashIV = config('app.env') === 'production' ? config('config.ecpay_hash_iv') : config('config.ecpay_stage_hash_iv');
    }

    public function paymentProcess(Request $request)
    {

        // 驗證驗證碼
        if ($request->captcha != session('captcha_code')) {
            return redirect()->back()->with('error', '驗證碼錯誤');
        }

        // 獲取購物車資料
        $cart = session('cart', []);
        // 計算訂單總金額
        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // 建立訂單
        $order = new Order();
        $shippingFee = Setting::getValue('shipping_fee', 60);

        // 生成訂單編號
        $today = date('Ymd');
        $lastOrder = Order::where('order_number', 'like', "OID{$today}%")
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $order->order_number = "OID" . $today . $newNumber;
        $order->order_id = 'OID-' . $today . $newNumber;
        $order->member_id = Auth::guard('member')->id();
        $order->total_amount = $totalAmount;
        $order->status = Order::STATUS_PENDING;

        // 付款相關
        $order->payment_method = $this->getPaymentMethod($request->payment);
        $order->payment_status = Order::PAYMENT_STATUS_PENDING;

        // 運送相關
        $order->shipment_method = $request->shipment;
        $order->shipping_status = Order::SHIPPING_STATUS_PENDING;
        $order->shipping_fee = $shippingFee;

        // 收件人資訊
        $order->recipient_name = $request->username;
        $order->recipient_phone = $request->phone;
        $order->recipient_gender = $request->gender;
        $order->shipping_county = $request->county ?? '';
        $order->shipping_district = $request->district ?? '';
        $order->shipping_address = $request->address ?? '';
        $order->store_id = $request->store_id ?? '';
        $order->store_name = $request->store_name ?? '';
        $order->store_address = $request->store_address ?? '';
        $order->store_telephone = $request->store_telephone ?? '';

        // 發票資訊
        $order->receipt_type = $request->receipt;
        if ($request->receipt == '3') {
            $order->invoice_title = $request->invoice_title;
            $order->invoice_number = $request->invoice_taxid;
            $order->invoice_county = $request->invoice_county;
            $order->invoice_district = $request->invoice_district;
            $order->invoice_address = $request->invoice_address;
        }

        // 備註
        $order->note = $request->info;

        $order->save();

        // 建立訂單項目
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'spec_id' => $item['spec_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity']
            ]);
        }

        // 準備綠界支付需要的資料
        $ecpayData = [
            'MerchantID' => $this->merchantID,
            'MerchantTradeNo' => $order->order_number,
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType' => 'aio',
            'TotalAmount' => $order->total_amount + $shippingFee,
            'TradeDesc' => '商品訂單',
            'ItemName' => $this->getItemNames($cart),
            'ReturnURL' => route('payment.notify'),
            'OrderResultURL' => route('payment.callback'),
            'ChoosePayment' => $this->getECPayMethod($request->payment),
            'EncryptType' => 1,
            'ClientBackURL' => route('payment.callback'),
        ];

        // 加入檢查碼
        $ecpayData['CheckMacValue'] = $this->generateCheckMacValue($ecpayData);

        // 清空購物車
        session()->forget(['cart']);

        // 回傳表單到前端自動提交
        return view('frontend.payment.ecpay-form', [
            'apiUrl' => config('app.env') === 'production'
                ? 'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5'
                : 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5',
            'ecpayData' => $ecpayData
        ]);
    }

    private function getPaymentMethod($payment)
    {
        return $payment == 1 ? Order::PAYMENT_METHOD_CREDIT : Order::PAYMENT_METHOD_ATM;
    }

    private function getItemNames($cart)
    {
        return collect($cart)->map(function ($item) {
            return $item['product_name'] . ' x ' . $item['quantity'];
        })->implode('#');
    }

    private function getECPayMethod($payment)
    {
        switch ($payment) {
            case 'Credit':
                return 'Credit';
            case 'WebATM':
                return 'WebATM';
            default:
                return 'ALL';
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
}

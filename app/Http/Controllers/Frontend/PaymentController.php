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

class PaymentController extends Controller
{
    private $merchantID;
    private $hashKey;
    private $hashIV;

    public function __construct()
    {
        $this->merchantID = env('ECPAY_MERCHANT_ID');
        $this->hashKey = env('ECPAY_HASH_KEY');
        $this->hashIV = env('ECPAY_HASH_IV');
    }

    public function paymentProcess(Request $request)
    {
        // try {

        //     DB::beginTransaction();
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
        $lastOrder = Order::where('order_number', 'like', "{$today}%")
            ->orderBy('order_number', 'desc')
            ->first();

        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $order->order_number = $today . $newNumber;
        $order->order_id = 'OID-' . $today . $newNumber;
        $order->member_id = Auth::guard('member')->id();
        $order->total_amount = $totalAmount;
        $order->status = Order::STATUS_PENDING;

        // 付款相關
        $order->payment_method = $this->getPaymentMethod($request->payment);
        $order->payment_status = Order::PAYMENT_STATUS_PENDING;

        // 運送相關
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
                'specification_id' => $item['specification_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity']
            ]);
        }

        DB::commit();

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
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return back()->with('error', '訂單建立失敗，請稍後再試');
        // }
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
            case 'ATM_TAISHIN':
            case 'ATM_ESUN':
            case 'ATM_BOT':
            case 'ATM_FUBON':
            case 'ATM_CHINATRUST':
            case 'ATM_FIRST':
                return Order::PAYMENT_METHOD_ATM;
            default:
                return $ecpayPaymentType;
        }
    }

    private function getPaymentMethod($payment)
    {
        return $payment == 1 ? Order::PAYMENT_METHOD_CREDIT : Order::PAYMENT_METHOD_ATM;
    }

    private function getECPayMethod($payment)
    {
        switch ($payment) {
            case 1:
                return 'Credit';
            case 2:
                return 'ATM';
            default:
                return 'ALL';
        }
    }

    private function getItemNames($cart)
    {
        return collect($cart)->map(function ($item) {
            return $item['product_name'] . ' x ' . $item['quantity'];
        })->implode('#');
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
}

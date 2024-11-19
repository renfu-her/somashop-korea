<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private $merchantID = env('ECPAY_MERCHANT_ID'); // 請替換為您的特店編號
    private $hashKey = env('ECPAY_HASH_KEY');       // 請替換為您的 HashKey
    private $hashIV = env('ECPAY_HASH_IV');         // 請替換為您的 HashIV
    
    public function paymentProcess(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // 建立訂單
            $order = new Order();
            $order->order_number = "OID-" . date('YmdHis');
            $order->member_id = auth()->guard('member')->id();
            $order->total_amount = session('cart_total', 0);
            $order->status = Order::STATUS_PENDING;
            
            // 付款相關
            $order->payment_method = $this->getPaymentMethod($request->payment);
            $order->payment_status = Order::PAYMENT_STATUS_PENDING;
            
            // 運送相關
            $order->shipping_method = $request->shippment;
            $order->shipping_status = Order::SHIPPING_STATUS_PENDING;
            
            // 收件人資訊
            $order->recipient_name = $request->username;
            $order->recipient_phone = $request->phone;
            $order->recipient_gender = $request->gender;
            
            // ... 其他訂單資訊設置 ...
            
            $order->save();

            // 建立訂單項目
            $cart = session('cart', []);
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
                'TotalAmount' => $order->total_amount,
                'TradeDesc' => '商品訂單',
                'ItemName' => $this->getItemNames($cart),
                'ReturnURL' => route('payment.notify'),
                'OrderResultURL' => route('payment.result'),
                'ChoosePayment' => $this->getECPayMethod($request->payment),
                'EncryptType' => 1,
                'ClientBackURL' => route('payment.result'),
            ];
            
            // 加入檢查碼
            $ecpayData['CheckMacValue'] = $this->generateCheckMacValue($ecpayData);

            // 清空購物車
            session()->forget(['cart', 'cart_total']);

            // 回傳表單到前端自動提交
            return view('frontend.payment.ecpay-form', [
                'apiUrl' => config('app.env') === 'production' 
                    ? 'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5'
                    : 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5',
                'ecpayData' => $ecpayData
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '訂單建立失敗，請稍後再試');
        }
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
        return collect($cart)->map(function($item) {
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

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MailService;
use App\Models\Member;
use App\Models\Order;
use App\Http\Controllers\Frontend\PaymentController;

class TestController extends Controller
{

    protected $captchaService;
    protected $mailService;
    protected $paymentController;

    public function __construct(
        MailService $mailService,
        PaymentController $paymentController
    ) {
        $this->mailService = $mailService;
        $this->paymentController = $paymentController;
    }
    public function test(MailService $mailService)
    {

        $member = Member::where('email', 'renfu.her@gmail.com')->first();
        $this->mailService->send(
            $member->email,
            '歡迎加入會員',
            [
                'title' => '歡迎加入',
                'content' => "親愛的 {$member->name} 您好，\n\n感謝您加入我們的會員...",
                'button' => [
                    'text' => '購物網站，您可以開始購物了！',
                    'url' => route('home')
                ]
            ],
            'emails.content',
            ['member' => $member]
        );
    }

    public function testLogistics()
    {
        // 獲取測試訂單和會員
        $order = Order::where('order_number', 'OID202411200008')->first();
        $member = Member::find($order->member_id);

        if (!$order || !$member) {
            return response()->json([
                'success' => false,
                'message' => '找不到測試訂單或會員'
            ], 404);
        }


        // 使用注入的 PaymentController 實例呼叫方法
        $result = $this->paymentController->createLogisticsOrder($order, $member);

        dd($result);

        return response()->json([
            'success' => $result,
            'order' => $order->toArray(),
            'logistics_info' => [
                'logistics_id' => $order->logistics_id,
                'logistics_type' => $order->logistics_type,
                'logistics_sub_type' => $order->logistics_sub_type,
                'cvs_payment_no' => $order->cvs_payment_no,
                'cvs_validation_no' => $order->cvs_validation_no,
                'booking_note' => $order->booking_note
            ]
        ]);
    }
}

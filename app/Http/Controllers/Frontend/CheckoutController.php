<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\CaptchaService;

class CheckoutController extends Controller
{
    protected $captchaService;
    
    public function __construct(CaptchaService $captchaService)
    {
        $this->captchaService = $captchaService;
    }

    public function index(Request $request)
    {
        // 獲取購物車資料
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', '購物車是空的');
        }

        // 計算總價
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 獲取會員資料
        $member = Auth::guard('member')->user();

        // 配送時段選項
        $timeSlots = [
            '09:00-10:00',
            '10:00-11:00',
            '11:00-12:00',
            '12:00-13:00',
            '13:00-14:00',
            '14:00-15:00',
            '15:00-16:00',
            '16:00-17:00',
            '17:00-18:00'
        ];

        return view('frontend.checkout.index', compact(
            'cart',
            'total',
            'member',
            'timeSlots'
        ));
    }

    public function validateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'delivery_method' => 'required|in:store,shipping',
            'delivery_time' => 'required_if:delivery_method,store',
            'county' => 'required_if:delivery_method,shipping',
            'district' => 'required_if:delivery_method,shipping',
            'address' => 'required_if:delivery_method,shipping',
            'captcha' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // 驗證驗證碼
        if (!$this->captchaService->validate($request->captcha)) {
            return response()->json([
                'success' => false,
                'errors' => ['captcha' => ['驗證碼錯誤']]
            ], 422);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function generateCaptcha()
    {
        return $this->captchaService->generateCaptcha();
    }
}

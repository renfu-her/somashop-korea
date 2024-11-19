<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\CaptchaService;
use Illuminate\Support\Facades\Http;

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

        return view('frontend.checkout.index', compact(
            'cart',
            'total',
            'member',
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

    // 產生驗證碼
    public function generateCaptcha()
    {
        return $this->captchaService->generateCaptcha();
    }

    // 開啟 7-11 門市地圖
    public function openSevenMap(Request $request, $shippmentType)
    {

        $logisticsSubType = 'UNIMART';

        if (env('APP_ENV') == 'production') {
            $mapApi = config('config.ecpay_map_api');
        } else {
            $mapApi = config('config.ecpay_stage_map_api');
        }

        $parameters  = [
            'MerchantID' => config('config.ecpay_merchant_id'),
            'LogisticsType' => 'CVS',
            'LogisticsSubType' => $logisticsSubType,
            'ServerReplyURL' => url('checkout/map/rewrite'),
            'IsCollection' => 'N'
        ];

        return redirect($mapApi . '?' . http_build_query($parameters));
    }

    // 開啟全家門市地圖
    public function openFamilyMap(Request $request, $shippmentType)
    {
        $logisticsSubType = 'FAMI';

        if (env('APP_ENV') == 'production') {
            $mapApi = config('config.ecpay_map_api');
        } else {
            $mapApi = config('config.ecpay_stage_map_api');
        }

        $parameters  = [
            'MerchantID' => config('config.ecpay_merchant_id'),
            'LogisticsType' => 'CVS',
            'LogisticsSubType' => $logisticsSubType,
            'ServerReplyURL' => url('checkout/map/rewrite'),
            'IsCollection' => 'N'
        ];

        return redirect($mapApi . '?' . http_build_query($parameters));
    }

    public function rewriteMap(Request $request)
    {
        // 關閉 CSRF 驗證
        $this->middleware('web');
        
        $data = $request->all();
        
        // 將門市資料存入 session
        session()->put('selected_store', [
            'store_id' => $data['CVSStoreID'],
            'store_name' => $data['CVSStoreName'],
            'store_address' => $data['CVSAddress'],
            'store_telephone' => $data['CVSTelephone'],
        ]);


        session()->save();
        
        // 關閉視窗並傳送資料給父視窗
        return view('frontend.checkout.store-callback', [
            'store_data' => $data
        ]);
    }

    /**
     * 獲取已選擇的門市資訊
     */
    public function getSelectedStore()
    {
        $store = session()->get('selected_store');
        return response()->json([
            'success' => true,
            'store' => $store
        ]);
    }

    public function payment(Request $request)
    {
        dd($request->all());
    }
}

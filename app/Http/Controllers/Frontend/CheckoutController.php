<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\CaptchaService;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use App\Models\FreeShipping;
class CheckoutController extends Controller
{
    protected $captchaService;
    protected $merchantID;
    protected $hashKey;
    protected $hashIV;

    public function __construct(CaptchaService $captchaService)
    {
        $this->captchaService = $captchaService;
        $this->merchantID = config('app.env') === 'production' ? config('config.ecpay_merchant_id') : config('config.ecpay_stage_merchant_id');
        $this->hashKey = config('app.env') === 'production' ? config('config.ecpay_hash_key') : config('config.ecpay_stage_hash_key');
        $this->hashIV = config('app.env') === 'production' ? config('config.ecpay_hash_iv') : config('config.ecpay_stage_hash_iv');

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

        // 獲取不同的運費設定
        $mailShippingFee = Setting::getValue('shipping_fee', 0);
        $sevenShippingFee = Setting::getValue('711_shipping_fee', 0);
        $familyShippingFee = Setting::getValue('family_shipping_fee', 0);

        // 配送方式設定
        $shippingSettings = [
            'mail_send' => [
                'name' => '郵寄',
                'fee' => $mailShippingFee,
            ],
            '711_b2c' => [
                'name' => '7-11 店到店',
                'fee' => $sevenShippingFee,
            ],
            'family_b2c' => [
                'name' => '全家 店到店',
                'fee' => $familyShippingFee,
            ]
        ];

        // 獲取已選擇的門市資訊
        $selectedStore = session()->get('selected_store');

        // 預設運費
        $shippingFee = 0;

        // 獲取免運門檻
        // 1. 永久有效的免運設定 (start_date 和 end_date 都為空)
        // 2. 限時免運設定 (在有效期間內)
        $freeShippings = FreeShipping::where('is_active', 1)
            ->where(function($query) {
                $query->where(function($q) {
                    // 永久有效
                    $q->whereNull('start_date')
                      ->whereNull('end_date');
                })->orWhere(function($q) {
                    // 限時有效且在有效期間內
                    $q->whereNotNull('start_date')
                      ->whereNotNull('end_date')
                      ->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
                });
            })
            ->orderBy('minimum_amount', 'desc')
            ->first();

        $freeShippings = $freeShippings && $total >= $freeShippings->minimum_amount ? $freeShippings->minimum_amount : 0;

        return view('frontend.checkout.index', compact(
            'cart',
            'total',
            'member',
            'shippingFee',
            'shippingSettings',
            'selectedStore',
            'freeShippings'
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

        $logisticsSubType = 'UNIMARTC2C';

        if (config('config.app_run') == 'production') {
            $mapApi = config('config.ecpay_map_api');
            $merchantId = config('config.ecpay_merchant_id');
        } else {
            $mapApi = config('config.ecpay_stage_map_api');
            $merchantId = config('config.ecpay_stage_merchant_id');
        }

        dd($mapApi, $merchantId);

        // 7-11 門市地圖
        $parameters  = [
            'MerchantID' => $merchantId,
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
        $logisticsSubType = 'FAMIC2C';

        if (config('config.app_run') == 'production') {
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

    public function validateInvoiceNumber(Request $request)
    {

        // dd($request->all());

        try {
            $validator = Validator::make($request->all(), [
                'invoice_taxid' => 'required|string|size:8'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => '統一編號格式不正確'
                ], 422);
            }

            // 準備 API 參數
            $timestamp = time();
            $merchantId = $this->merchantID;
            
            $apiUrl = config('app.env') === 'production'
                ? 'https://einvoice.ecpay.com.tw/B2CInvoice/GetCompanyNameByTaxID'
                : 'https://einvoice-stage.ecpay.com.tw/B2CInvoice/GetCompanyNameByTaxID';

            // 準備加密資料
            $data = [
                'MerchantID' => $merchantId,
                'UnifiedBusinessNo' => $request->invoice_taxid
            ];

            // 發送請求到綠界 API
            $response = Http::post($apiUrl, [
                'MerchantID' => $merchantId,
                'RqHeader' => [
                    'Timestamp' => $timestamp
                ],
                'Data' => $this->encryptData($data) // 需要實作加密方法
            ]);

            $result = $response->json();
            
            if ($result['TransCode'] === 1) {
                $decryptedData = $this->decryptData($result['Data']); // 需要實作解密方法
                
                if ($decryptedData['RtnCode'] === 1) {
                    return response()->json([
                        'success' => true,
                        'company_name' => $decryptedData['CompanyName']
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => '統一編號驗證失敗'
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '系統錯誤，請稍後再試'
            ], 500);
        }
    }

    private function encryptData($data)
    {
        // 將資料轉換為 JSON 字串
        $jsonData = json_encode($data);
        
        // URL encode
        $urlEncodedData = urlencode($jsonData);
        
        // AES 加密
        $cipher = 'aes-128-cbc';
        $options = OPENSSL_RAW_DATA;
        $encrypted = openssl_encrypt(
            $urlEncodedData,
            $cipher,
            $this->hashKey,
            $options,
            $this->hashIV
        );
        
        // Base64 編碼
        return base64_encode($encrypted);
    }

    private function decryptData($encryptedData)
    {
        // Base64 解碼
        $encrypted = base64_decode($encryptedData);
        
        // AES 解密
        $cipher = 'aes-128-cbc';
        $options = OPENSSL_RAW_DATA;
        $decrypted = openssl_decrypt(
            $encrypted,
            $cipher,
            $this->hashKey,
            $options,
            $this->hashIV
        );
        
        // URL decode
        $urlDecodedData = urldecode($decrypted);
        
        // JSON 解析
        return json_decode($urlDecodedData, true);
    }

}

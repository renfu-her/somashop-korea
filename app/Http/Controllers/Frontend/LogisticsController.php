<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogisticsController extends Controller
{
    public function notify(Request $request)
    {
        Log::info('物流狀態通知', $request->all());

        // 驗證資料
        if (!$this->verifyCheckMacValue($request->all())) {
            return 'CheckMacValue 驗證失敗';
        }

        // 取得訂單
        $order = Order::where('logistics_id', $request->AllPayLogisticsID)->first();
        if (!$order) {
            return '0|找不到訂單';
        }

        // 更新物流狀態
        switch ($request->RtnCode) {
            case 2067: // 建立物流訂單成功
                $order->shipping_status = Order::SHIPPING_STATUS_PROCESSING;
                break;
            case 2068: // 商品已送達
                $order->shipping_status = Order::SHIPPING_STATUS_DELIVERED;
                break;
            case 3001: // 商品已出貨
                $order->shipping_status = Order::SHIPPING_STATUS_SHIPPED;
                break;
            default:
                Log::warning('未處理的物流狀態碼', [
                    'RtnCode' => $request->RtnCode,
                    'order_id' => $order->id
                ]);
                break;
        }

        $order->save();
        return '1|OK';
    }

    public function storeNotify(Request $request)
    {
        Log::info('超商通知', $request->all());

        // 驗證資料
        if (!$this->verifyCheckMacValue($request->all())) {
            return '0|CheckMacValue 驗證失敗';
        }

        // 取得訂單
        $order = Order::where('logistics_id', $request->AllPayLogisticsID)->first();
        if (!$order) {
            return '0|找不到訂單';
        }

        // 更新超商資訊
        $order->update([
            'store_id' => $request->CVSStoreID ?? null,
            'store_name' => $request->CVSStoreName ?? null,
            'store_address' => $request->CVSAddress ?? null,
        ]);

        return '1|OK';
    }

    private function verifyCheckMacValue($data)
    {
        // 實作 CheckMacValue 驗證邏輯
        return true; // 暫時返回 true，實際應該實作驗證
    }
} 
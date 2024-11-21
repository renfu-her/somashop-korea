<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Product;
use App\Models\Advert;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $actives = Activity::orderByDesc('id')->get();
        
        // 獲取最新商品
        $hotProducts = Product::with('primaryImage')
            ->where('is_active', 1)
            ->where('is_new', 1)
            ->orderByDesc('id')
            ->get();

        // 獲取當前有效的廣告
        $now = Carbon::now();
        
        $ads = Advert::where('is_active', 1)  // 啟用狀態
            ->where(function($query) use ($now) {
                $query->where(function($q) use ($now) {
                    // 如果有設定開始和結束日期，檢查是否在日期範圍內
                    $q->whereNotNull('start_date')
                      ->whereNotNull('end_date')
                      ->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now);
                })->orWhere(function($q) {
                    // 如果沒有設定日期，則視為永久有效
                    $q->whereNull('start_date')
                      ->whereNull('end_date');
                });
            })
            ->orderByDesc('id')      // 相同排序則依照ID降序
            ->get();

        return view('frontend.home', compact('actives', 'hotProducts', 'ads'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Product;
use App\Models\Advert;
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
            ->limit(6)
            ->get();

        $adverts = Advert::orderByDesc('id')->get();

        return view('frontend.home', compact('actives', 'hotProducts', 'adverts'));
    }
}

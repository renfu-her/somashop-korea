<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Product;
use App\Models\Advert;
use App\Models\HomeAd;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $actives = Activity::orderByDesc('id')->get();

        $hotProducts = Product::with('primaryImage')
            ->where('is_active', 1)
            ->where('is_hot', 1)
            ->orderByDesc('id')
            ->get();

        $now = Carbon::now();
        $ads = Advert::where('is_active', 1)
            ->where(function ($query) use ($now) {
                $query->where(function ($q) use ($now) {
                    $q->whereNotNull('start_date')
                        ->whereNotNull('end_date')
                        ->where('start_date', '<=', $now)
                        ->where('end_date', '>=', $now);
                })->orWhere(function ($q) {
                    $q->whereNull('start_date')
                        ->whereNull('end_date');
                })->orWhere(function ($q) use ($now) {
                    $q->whereNotNull('start_date')
                        ->whereNull('end_date')
                        ->where('start_date', '<=', $now);
                });
            })
            ->orderByDesc('id')
            ->get();

        $homeAds = HomeAd::where('is_active', 1)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('frontend.home', compact('actives', 'hotProducts', 'ads', 'homeAds'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return view('frontend.order.index');
    }

    public function orderShow($order)
    {
        return view('frontend.order.show', compact('order'));
    }

    public function orderList()
    {
        $memberId = Auth::guard('member')->user()->id;
        $orders = Order::with([
            'items.product.primaryImage',
            'items.spec',
            'member'
        ])->where('member_id', $memberId)
        ->orderBy('created_at', 'desc')
        ->get();

        foreach ($orders as $order) {
            $order->items = $order->items->map(function ($item) {
                $specName = $item->spec ? $item->spec->name : '規格已刪除';
                return [
                    'name' => $item->product->name,
                    'spec' => $specName,
                    'image_path' => $item->product->primaryImage?->getImageUrlAttribute()
                ];
            });
        }

        return view('frontend.order.list', compact('orders'));
    }
}

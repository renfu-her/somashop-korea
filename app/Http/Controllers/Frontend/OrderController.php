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
        $orders = Order::with(['items.product', 'items.spec', 'member'])->where('member_id', $memberId)->get();

        foreach ($orders as $order) {
            $order->items = $order->items->map(function ($item) {
                $specName = $item->spec ? $item->spec->name : '規格已刪除';
                return $item->product->name . '<br>規格：' . $specName;
            });
        }

        return view('frontend.order.list', compact('orders'));
    }
}

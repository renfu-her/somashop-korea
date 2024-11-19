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
        $orders = Order::with(['items', 'member'])->where('member_id', $memberId)->get();

        foreach ($orders as $order) {
            $order->items = $order->items->map(function ($item) {
                return $item->product->name . '<br>' . $item->specification->name;
            });
        }

        // dd($orders);

        return view(
            'frontend.order.list',
            compact('orders')
        );
    }
}

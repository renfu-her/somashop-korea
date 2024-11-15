<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $orderItem = session('order_item');
        if (!$orderItem) {
            return redirect()->route('home');
        }

        return view('frontend.checkout.index', compact('orderItem'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255'
        ]);

        $orderItem = session('order_item');
        
        // 建立訂單
        $order = Order::create([
            'order_number' => 'ORD-' . time(),
            'user_id' => auth()->id(),
            'total_amount' => $orderItem['total'],
            'status' => Order::STATUS_PENDING,
            'shipping_method' => 'delivery',
            'shipping_fee' => 0,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'shipping_address' => $request->shipping_address,
            'note' => $request->note
        ]);

        // 建立訂單項目
        $order->items()->create($orderItem);

        // 清除 session
        session()->forget('order_item');

        return redirect()->route('orders.show', $order->id)
            ->with('success', '訂單已成功建立');
    }
} 
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['member', 'items.product', 'items.spec', 'items.productImage'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['member', 'items.product', 'items.spec', 'items.productImage']);
        return view('admin.orders.show', compact('order'));
    }
} 
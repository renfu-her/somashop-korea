<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, $productId)
    {
        dd($request->all());
        $request->validate([
            'specification' => 'required|exists:product_specifications,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($productId);
        
        // 建立訂單項目
        $orderItem = [
            'product_id' => $product->id,
            'specification_id' => $request->specification,
            'quantity' => $request->quantity,
            'price' => $product->cash_price,
            'total' => $product->cash_price * $request->quantity
        ];

        // 存入 session
        session()->put('order_item', $orderItem);

        return redirect()->route('checkout.index');
    }
} 
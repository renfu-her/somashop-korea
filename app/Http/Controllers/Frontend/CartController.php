<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with(['items.product', 'items.specification'])
            ->first();

        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'specification' => 'required|exists:product_specifications,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        // 檢查是否已存在相同商品和規格
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('specification_id', $request->specification)
            ->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'specification_id' => $request->specification,
                'quantity' => $request->quantity,
                'price' => $product->cash_price
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', '商品已加入購物車');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($item->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $item->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => '數量已更新',
            'total' => number_format($item->price * $item->quantity)
        ]);
    }

    public function remove(CartItem $item)
    {
        if ($item->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('cart.index')
            ->with('success', '商品已從購物車移除');
    }
} 
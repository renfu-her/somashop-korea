<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $total = 0;

        // 計算總價
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view(
            'frontend.checkout.index',
            compact('cart', 'total')
        );
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'specification_id' => 'required|exists:product_specifications,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $specification = ProductSpecification::findOrFail($validated['specification_id']);

        // 計算總價
        $total = $product->cash_price * $validated['quantity'];

        return view('frontend.checkout.index', compact('product', 'specification', 'total', 'validated'));
    }

    public function removeFromCart(Request $request)
    {
        $cartItemKey = $request->cart_item_key;
        $cart = session()->get('cart', []);

        if (isset($cart[$cartItemKey])) {
            unset($cart[$cartItemKey]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => '商品已從購物車移除']);
    }

    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'cart_item_key' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$validated['cart_item_key']])) {
            $cart[$validated['cart_item_key']]['quantity'] = $validated['quantity'];
            session()->put('cart', $cart);
        }

        return response()->json(['message' => '數量已更新']);
    }
}

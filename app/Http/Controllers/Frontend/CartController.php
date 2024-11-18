<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function index(Request $request)
    {
        
        if(session()->has('cart')){
            $cart = session()->get('cart', []);
        }else{
            $cart = [];
        }

        if (empty($cart)) {
            return redirect()->route('home')->with('error', '購物車是空的');
        }
        $total = 0;

        // 計算總價
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view(
            'frontend.cart.index',
            compact('cart', 'total')
        );
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'specification_id' => 'required|exists:product_specifications,id',
            'quantity' => 'required|integer|min:1',
            'checkout_direct' => 'boolean'
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $specification = ProductSpecification::findOrFail($validated['specification_id']);

        // 獲取當前購物車
        $cart = session()->get('cart', []);

        // 新增商品到購物車
        $cart[] = [
            'product_id' => $validated['product_id'],
            'specification_id' => $validated['specification_id'],
            'quantity' => $validated['quantity'],
            'price' => $product->cash_price,
            'product_name' => $product->name,
            'specification_name' => $specification->name,
            'primary_image' => asset('storage/products/' . $validated['product_id'] . '/' . $product->primaryImage->image_path)
        ];

        session()->put('cart', $cart);

        // 根據 checkout_direct 參數決定跳轉
        if ($request->boolean('checkout_direct')) {
            return redirect()->route('checkout.index');
        }

        return redirect()->route('cart.index');
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'specification_id' => 'required|exists:product_specifications,id',
            'quantity' => 'required|integer|min:1',
            'checkout_direct' => 'boolean'
        ]);

        // 獲取當前購物車
        $cart = session()->get('cart', []);

        // 新增商品到購物車
        $cartItem = [
            'product_id' => $validated['product_id'],
            'specification_id' => $validated['specification_id'],
            'quantity' => $validated['quantity']
        ];
        
        // 存储到购物车 session
        $cart[] = $cartItem;
        session()->put('cart', $cart);

        // 根据 checkout_direct 参数决定跳转
        if ($request->boolean('checkout_direct')) {
            return redirect()->route('checkout');
        }

        return redirect()->back()->with('success', '商品已加入購物車');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($item->cart->user_id !== Auth::guard('member')->id()) {
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
        if ($item->cart->user_id !== Auth::guard('member')->id()) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('cart.index')
            ->with('success', '商品已從購物車移除');
    }
}

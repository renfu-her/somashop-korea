<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['user', 'product'])->get();

        return view('admin.carts.index', compact('carts'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.carts.create', compact('users', 'products'));
    }

    public function edit($id)
    {
        $cart = Cart::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('admin.carts.edit', compact('cart', 'users', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        Cart::create($validated);

        return redirect()->route('admin.carts.index')->with('success', '購物車項目已創建');
    }

    public function show($id)
    {
        $cart = Cart::with(['user', 'product'])->findOrFail($id);

        return view('admin.carts.show', compact('cart'));
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'exists:users,id',
            'product_id' => 'exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        $cart->update($validated);

        return redirect()->route('admin.carts.index')->with('success', '購物車項目已更新');
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->route('admin.carts.index')->with('success', '購物車項目已刪除');
    }
}

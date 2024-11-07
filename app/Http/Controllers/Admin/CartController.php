<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 獲取所有用戶的購物車列表
    public function index()
    {
        $carts = Cart::with(['user', 'product'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $carts
        ]);
    }

    // 獲取特定用戶的購物車
    public function getUserCart($userId)
    {
        $user = User::findOrFail($userId);
        $carts = Cart::where('user_id', $userId)
            ->with('product')
            ->get();

        return response()->json([
            'status' => 'success',
            'user' => $user->name,
            'data' => $carts
        ]);
    }

    // 管理員更新購物車項目
    public function update(Request $request, $cartId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = Cart::findOrFail($cartId);

        if ($validated['quantity'] === 0) {
            $cart->delete();
            return response()->json([
                'status' => 'success',
                'message' => '購物車項目已刪除'
            ]);
        }

        $cart->update([
            'quantity' => $validated['quantity']
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $cart->load('product', 'user')
        ]);
    }

    // 管理員刪除購物車項目
    public function destroy($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->delete();

        return response()->json([
            'status' => 'success',
            'message' => '購物車項目已刪除'
        ]);
    }

    // 獲取購物車統計資訊
    public function statistics()
    {
        $statistics = [
            'total_carts' => Cart::count(),
            'total_users_with_carts' => Cart::distinct('user_id')->count(),
            'most_carted_products' => Cart::select('product_id')
                ->with('product:id,name')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('product_id')
                ->orderByDesc('count')
                ->limit(5)
                ->get()
        ];

        return response()->json([
            'status' => 'success',
            'data' => $statistics
        ]);
    }
}

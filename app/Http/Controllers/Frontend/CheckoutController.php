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
        dd($request->all());

        return view('frontend.checkout.index');
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
} 
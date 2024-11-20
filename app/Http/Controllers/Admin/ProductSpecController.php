<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Http\Request;

class ProductSpecController extends Controller
{
    public function index(Product $product)
    {
        $specs = $product->specs()->orderBy('sort_order')->get();
        return view('admin.products.specs.index', compact('product', 'specs'));
    }

    public function create(Product $product)
    {
        return view('admin.products.specs.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $product->specs()->create($validated);

        return redirect()->route('admin.products.specs.index', $product->id)
            ->with('success', '產品規格已成功創建');
    }

    public function edit(Product $product, ProductSpec $spec)
    {
        return view('admin.products.specs.edit', compact('product', 'spec'));
    }

    public function update(Request $request, Product $product, ProductSpec $spec)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer'
        ]);

        $spec->update($validated);

        return redirect()->route('admin.products.specs.index', $product->id)
            ->with('success', '產品規格已成功更新');
    }

    public function destroy(Product $product, ProductSpec $spec)
    {
        $spec->delete();
        
        return redirect()->route('admin.products.specs.index', $product->id)
            ->with('success', '產品規格已成功刪除');
    }
} 
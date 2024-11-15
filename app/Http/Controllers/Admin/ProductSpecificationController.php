<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

class ProductSpecificationController extends Controller
{
    public function index($productId)
    {
        $product = Product::findOrFail($productId);
        $specifications = $product->specifications()->orderBy('sort_order')->get();

        return view('admin.product-specifications.index', compact('product', 'specifications'));
    }

    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        return view('admin.product-specifications.create', compact('product'));
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $product = Product::findOrFail($productId);
        $product->specifications()->create([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.products.specifications.index', $productId)
            ->with('success', '規格已成功創建');
    }

    public function edit($productId, $id)
    {
        $product = Product::findOrFail($productId);
        $specification = ProductSpecification::findOrFail($id);
        
        return view('admin.product-specifications.edit', compact('product', 'specification'));
    }

    public function update(Request $request, $productId, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $specification = ProductSpecification::findOrFail($id);
        $specification->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.products.specifications.index', $productId)
            ->with('success', '規格已成功更新');
    }

    public function destroy($productId, $id)
    {
        $specification = ProductSpecification::findOrFail($id);
        $specification->delete();

        return redirect()->route('admin.products.specifications.index', $productId)
            ->with('success', '規格已成功刪除');
    }
} 
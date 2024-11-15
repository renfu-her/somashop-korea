<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

class ProductSpecificationController extends Controller
{
    public function index()
    {
        $specifications = ProductSpecification::orderBy('name')->get();
        return view('admin.product-specifications.index', compact('specifications'));
    }

    public function create()
    {
        return view('admin.product-specifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        ProductSpecification::create([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.specifications.index')
            ->with('success', '規格已成功創建');
    }

    public function edit($id)
    {
        $specification = ProductSpecification::findOrFail($id);
        return view('admin.product-specifications.edit', compact('specification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $specification = ProductSpecification::findOrFail($id);
        $specification->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.specifications.index')
            ->with('success', '規格已成功更新');
    }

    public function destroy($id)
    {
        $specification = ProductSpecification::findOrFail($id);
        
        // 檢查是否有關聯的訂單或購物車項目
        if ($specification->orderItems()->exists() || $specification->cartItems()->exists()) {
            return back()->with('error', '此規格已被使用，無法刪除');
        }

        $specification->delete();

        return redirect()->route('admin.specifications.index')
            ->with('success', '規格已成功刪除');
    }
} 
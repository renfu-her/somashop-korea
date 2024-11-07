<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->latest()
            ->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category = Category::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => '分類已創建',
            'data' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::with('products')
            ->withCount('products')
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string'
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => '分類已更新',
            'data' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // 檢查是否有關聯的商品
        if ($category->products()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => '無法刪除含有商品的分類'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => '分類已刪除'
        ]);
    }
}

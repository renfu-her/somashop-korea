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
        $categories = Category::where('parent_id', 0)
            ->with(['children' => function($query) {
                $query->orderBy('sort_order', 'asc')->withCount('products');
            }])
            ->orderBy('sort_order', 'asc')
            ->withCount('products')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::where('parent_id', 0)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'required|integer|min:0',
            'sort_order' => 'required|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', '分類創建成功！');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::where('parent_id', 0)
            ->where('id', '!=', $category->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'required|integer|min:0',
            'sort_order' => 'required|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', '分類更新成功！');
    }

    public function destroy(Category $category)
    {
        // 檢查是否有子分類
        if ($category->children()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', '無法刪除含有子分類的分類！');
        }

        // 檢查是否有關聯的商品
        if ($category->products()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', '無法刪除此分類，因為還有相關聯的商品！');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', '分類刪除成功！');
    }
}

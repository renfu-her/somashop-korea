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
            ->with(['children' => function ($query) {
                $query->withCount('products')
                    ->orderBy('created_at', 'desc');
            }])
            ->where('parent_id', 0)
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::where('parent_id', 0)->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'required|integer|min:0'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', '分類已創建');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parentCategories = Category::where('parent_id', 0)
            ->where('id', '!=', $id)
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'parent_id' => 'required|integer|min:0'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', '分類已更新');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', '分類已刪除');
    }
}

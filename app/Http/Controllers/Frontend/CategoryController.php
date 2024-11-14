<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getSidebarCategories()
    {
        // 獲取所有頂層分類（parent_id = 0）及其子分類
        $categories = Category::where('parent_id', 0)
            ->with('allChildren')
            ->get();

        return $categories;
    }

    // 用於顯示特定分類的商品
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['children', 'parent'])
            ->firstOrFail();

        // 如果需要獲取當前分類的所有上層分類（用於麵包屑導航）
        $breadcrumbs = collect([]);
        $current = $category;
        
        while ($current->parent) {
            $breadcrumbs->prepend($current->parent);
            $current = $current->parent;
        }

        return view('frontend.category.show', compact('category', 'breadcrumbs'));
    }
} 
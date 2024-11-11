<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::withCount('faqs')
            ->orderBy('sort_order')
            ->paginate(15);

        return view('admin.faq-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.faq-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        // 確保 is_active 有值
        $validated['is_active'] = $request->has('is_active');

        FaqCategory::create($validated);

        return redirect()->route('admin.faq-categories.index')
            ->with('success', '常見問題分類已創建');
    }

    public function edit($id)
    {
        $category = FaqCategory::findOrFail($id);
        return view('admin.faq-categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = FaqCategory::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        // 確保 is_active 有值
        $validated['is_active'] = $request->has('is_active');
        
        $category->update($validated);

        return redirect()->route('admin.faq-categories.index')
            ->with('success', '常見問題分類已更新');
    }

    public function destroy($id)
    {
        $category = FaqCategory::findOrFail($id);
        
        // 檢查是否有關聯的常見問題
        if ($category->faqs()->count() > 0) {
            return redirect()->route('admin.faq-categories.index')
                ->with('error', '此分類下還有常見問題，無法刪除');
        }

        $category->delete();

        return redirect()->route('admin.faq-categories.index')
            ->with('success', '常見問題分類已刪除');
    }

    // 更新排序
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:faq_categories,id',
            'items.*.sort_order' => 'required|integer'
        ]);

        foreach ($validated['items'] as $item) {
            FaqCategory::where('id', $item['id'])
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['message' => '排序已更新']);
    }

    // 更新狀態
    public function updateStatus(Request $request, $id)
    {
        $category = FaqCategory::findOrFail($id);
        $category->update(['is_active' => $request->is_active]);

        return response()->json(['message' => '狀態已更新']);
    }
} 
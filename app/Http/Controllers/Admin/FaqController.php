<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $categories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $query = Faq::with('category')->orderBy('sort_order');
        
        // 如果有選擇分類
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $faqs = $query->get();
            
        return view('admin.faqs.index', compact('faqs', 'categories'));
    }

    public function create()
    {
        $categories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
            
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:faq_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        // 確保 is_active 有值
        $validated['is_active'] = $request->has('is_active');

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')
            ->with('success', '常見問題已創建');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:faq_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        // 確保 is_active 有值
        $validated['is_active'] = $request->has('is_active');
        
        $faq->update($validated);

        return redirect()->route('admin.faqs.index')
            ->with('success', '常見問題已更新');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', '常見問題已刪除');
    }

    // 更新排序
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:faqs,id',
            'items.*.sort_order' => 'required|integer'
        ]);

        foreach ($validated['items'] as $item) {
            Faq::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['message' => '排序已更新']);
    }

    // 更新狀態
    public function updateStatus(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update(['is_active' => $request->is_active]);

        return response()->json(['message' => '狀態已更新']);
    }

    public function toggleActive(Faq $faq, Request $request)
    {
        $faq->update([
            'is_active' => $request->is_active == 'true' ? 1 : 0
        ]);

        return response()->json([
            'success' => true,
            'message' => '狀態更新成功'
        ]);
    }
}

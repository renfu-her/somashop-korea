<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SealKnowledgeCategory;
use Illuminate\Http\Request;

class SealKnowledgeCategoryController extends Controller
{
    /**
     * 顯示分類列表
     */
    public function index()
    {
        $categories = SealKnowledgeCategory::withCount('sealKnowledges')
            ->orderBy('sort')
            ->get();

        return view('admin.seal-knowledge-category.index', compact('categories'));
    }

    /**
     * 顯示創建表單
     */
    public function create()
    {
        return view('admin.seal-knowledge-category.create');
    }

    /**
     * 儲存新分類
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:seal_knowledge_categories',
            'sort' => 'nullable|integer',
            'status' => 'boolean',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
        ]);

        try {
            SealKnowledgeCategory::create($validated);
            return redirect()
                ->route('admin.seal-knowledge-category.index')
                ->with('success', '分類建立成功');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '分類建立失敗：' . $e->getMessage());
        }
    }

    /**
     * 顯示單一分類
     */
    public function show(SealKnowledgeCategory $category)
    {
        return view('admin.seal-knowledge-category.show', compact('category'));
    }

    /**
     * 顯示編輯表單
     */
    public function edit(SealKnowledgeCategory $sealKnowledgeCategory)
    {
        return view('admin.seal-knowledge-category.edit', compact('sealKnowledgeCategory'));
    }

    /**
     * 更新分類
     */
    public function update(Request $request, SealKnowledgeCategory $sealKnowledgeCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:seal_knowledge_categories,name,' . $sealKnowledgeCategory->id,
            'sort' => 'nullable|integer',
            'status' => 'boolean',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
        ]);

        try {
            $sealKnowledgeCategory->update($validated);
            return redirect()
                ->route('admin.seal-knowledge-category.index')
                ->with('success', '分類更新成功');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '分類更新失敗：' . $e->getMessage());
        }
    }

    /**
     * 刪除分類
     */
    public function destroy(SealKnowledgeCategory $category)
    {
        try {
            // 檢查是否有關聯的文章
            if ($category->sealKnowledges()->count() > 0) {
                return back()->with('error', '此分類下還有文章，無法刪除');
            }

            $category->delete();
            return redirect()
                ->route('admin.seal-knowledge-category.index')
                ->with('success', '分類刪除成功');
        } catch (\Exception $e) {
            return back()->with('error', '分類刪除失敗：' . $e->getMessage());
        }
    }

    /**
     * 更新排序
     */
    public function updateSort(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:seal_knowledge_categories,id',
            'items.*.sort' => 'required|integer'
        ]);

        try {
            foreach ($validated['items'] as $item) {
                SealKnowledgeCategory::where('id', $item['id'])
                    ->update(['sort' => $item['sort']]);
            }
            return response()->json(['message' => '排序更新成功']);
        } catch (\Exception $e) {
            return response()->json(['error' => '排序更新失敗：' . $e->getMessage()], 500);
        }
    }

    /**
     * 切換狀態
     */
    public function toggleStatus(SealKnowledgeCategory $category)
    {
        try {
            $category->update([
                'status' => !$category->status
            ]);
            return response()->json([
                'message' => '狀態更新成功',
                'status' => $category->status
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => '狀態更新失敗：' . $e->getMessage()], 500);
        }
    }

    /**
     * 取得啟用中的分類列表（用於下拉選單）
     */
    public function getActiveCategories()
    {
        $categories = SealKnowledgeCategory::where('status', true)
            ->orderBy('sort')
            ->get(['id', 'name']);

        return response()->json($categories);
    }
}

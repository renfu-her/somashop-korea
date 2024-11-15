<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SealKnowledge;
use App\Models\SealKnowledgeCategory;
use Illuminate\Http\Request;

class SealKnowledgeController extends Controller
{
    /**
     * 顯示列表
     */
    public function index(Request $request)
    {
        $categories = SealKnowledgeCategory::where('status', true)
            ->orderBy('sort')
            ->get();

        $query = SealKnowledge::with('category')->orderBy('sort');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $knowledges = $query->get();

        return view('admin.seal-knowledge.index', compact('knowledges', 'categories'));
    }

    /**
     * 顯示創建表單
     */
    public function create()
    {
        $categories = SealKnowledgeCategory::where('status', true)->get();
        return view('admin.seal-knowledge.create', compact('categories'));
    }

    /**
     * 儲存新記錄
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:seal_knowledge_categories,id',
            'sort' => 'nullable|integer',
            'status' => 'boolean',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
        ]);

        try {
            $sealKnowledge = new SealKnowledge();
            $sealKnowledge->fill($validated);
            $sealKnowledge->save();
            return redirect()
                ->route('admin.seal-knowledge.index')
                ->with('success', '建立成功');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '建立失敗：' . $e->getMessage());
        }
    }

    /**
     * 顯示單筆記錄
     */
    public function show(SealKnowledge $sealKnowledge)
    {
        return view('admin.seal-knowledge.show', compact('sealKnowledge'));
    }

    /**
     * 顯示編輯表單
     */
    public function edit(SealKnowledge $sealKnowledge)
    {
        $categories = SealKnowledgeCategory::where('status', true)->get();
        return view('admin.seal-knowledge.edit', compact('sealKnowledge', 'categories'));
    }

    /**
     * 更新記錄
     */
    public function update(Request $request, SealKnowledge $sealKnowledge)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:seal_knowledge_categories,id',
            'sort' => 'nullable|integer',
            'status' => 'boolean',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
        ]);

        try {
            $sealKnowledge->update($validated);
            return redirect()
                ->route('admin.seal-knowledge.index')
                ->with('success', '更新成功');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', '更新失敗：' . $e->getMessage());
        }
    }

    /**
     * 刪除記錄
     */
    public function destroy(SealKnowledge $sealKnowledge)
    {
        try {
            $sealKnowledge->delete();
            return redirect()
                ->route('admin.seal-knowledge.index')
                ->with('success', '刪除成功');
        } catch (\Exception $e) {
            return back()->with('error', '刪除失敗：' . $e->getMessage());
        }
    }

    /**
     * 更新排序
     */
    public function updateSort(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:seal_knowledges,id',
            'items.*.sort' => 'required|integer'
        ]);

        try {
            foreach ($validated['items'] as $item) {
                SealKnowledge::where('id', $item['id'])
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
    public function toggleStatus(SealKnowledge $knowledge)
    {
        try {
            $knowledge->update([
                'status' => !$knowledge->status
            ]);
            return response()->json([
                'message' => '狀態更新成功',
                'status' => $knowledge->status
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => '狀態更新失敗：' . $e->getMessage()], 500);
        }
    }

    /**
     * 搜尋功能
     */
    public function search(Request $request)
    {
        $query = SealKnowledge::with('category');

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $knowledges = $query->orderBy('sort')->paginate(15);

        if ($request->ajax()) {
            return view('admin.seal-knowledge.partials.table', compact('knowledges'));
        }

        $categories = SealKnowledgeCategory::where('status', true)->get();
        return view('admin.seal-knowledge.index', compact('knowledges', 'categories'));
    }
}

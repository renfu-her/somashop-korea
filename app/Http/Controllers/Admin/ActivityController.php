<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class ActivityController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $activities = Activity::all();
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'date' => 'required|date'
        ]);

        // 創建活動
        $activity = Activity::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'content' => $validated['content'],
            'date' => $validated['date']
        ]);

        // 處理圖片上傳
        if ($request->hasFile('image')) {
            $filename = $this->imageService->uploadImage(
                $request->file('image'),
                "activities/{$activity->id}"
            );
            
            $activity->update([
                'image' => "activities/{$activity->id}/{$filename}"
            ]);
        }

        return redirect()
            ->route('admin.activities.index')
            ->with('success', '活動已成功創建');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'date' => 'required|date'
        ]);

        // 更新基本資料
        $activity->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'content' => $validated['content'],
            'date' => $validated['date']
        ]);

        // 處理圖片上傳
        if ($request->hasFile('image')) {
            // 刪除舊圖片
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }

            // 上傳新圖片
            $filename = $this->imageService->uploadImage(
                $request->file('image'),
                "activities/{$activity->id}"
            );
            
            $activity->update([
                'image' => "activities/{$activity->id}/{$filename}"
            ]);
        }

        return redirect()
            ->route('admin.activities.index')
            ->with('success', '活動已成功更新');
    }

    public function destroy(Activity $activity)
    {
        // 刪除圖片
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
            // 刪除整個活動資料夾
            Storage::disk('public')->deleteDirectory("activities/{$activity->id}");
        }

        $activity->delete();

        return redirect()
            ->route('admin.activities.index')
            ->with('success', '活動已成功刪除');
    }
} 
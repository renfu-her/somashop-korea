<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class HomeAdsController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $ads = HomeAd::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.home-ads.index', compact('ads'));
    }

    public function create()
    {
        return view('admin.home-ads.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:4096',
            'link' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image_thumb' => 'nullable|image|max:4096'
        ]);


        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $filename = $this->imageService->uploadImage(
                $request->file('image'),
                'home_ads'
            );
            $validated['image'] = $filename;
        }

        if ($request->hasFile('image_thumb')) {
            $filename = $this->imageService->uploadImage(
                $request->file('image_thumb'),
                'home_ads'
            );
            $validated['image_thumb'] = $filename;
        }

        HomeAd::create($validated);

        return redirect()->route('admin.home-ads.index')
            ->with('success', '廣告已成功創建');
    }

    public function edit(HomeAd $homeAd)
    {
        return view('admin.home-ads.edit', compact('homeAd'));
    }

    public function update(Request $request, HomeAd $homeAd)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
            'link' => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image_thumb' => 'nullable|image|max:4096'
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            // 刪除舊圖片
            if ($homeAd->image) {
                Storage::disk('public')->delete('home_ads/' . $homeAd->image);
            }

            // 上傳新圖片
            $filename = $this->imageService->uploadImage(
                $request->file('image'),
                'home_ads'
            );
            $validated['image'] = $filename;
        }

        if ($request->hasFile('image_thumb')) {
            if ($homeAd->image_thumb) {
                Storage::disk('public')->delete('home_ads/' . $homeAd->image_thumb);
            }

            $filename = $this->imageService->uploadImage(
                $request->file('image_thumb'),
                'home_ads'
            );
            $validated['image_thumb'] = $filename;
        }

        $homeAd->update($validated);

        return redirect()->route('admin.home-ads.index')
            ->with('success', '廣告已成功更新');
    }

    public function destroy(HomeAd $homeAd)
    {
        if ($homeAd->image) {
            Storage::disk('public')->delete('home_ads/' . $homeAd->image);
        }

        $homeAd->delete();

        return redirect()->route('admin.home-ads.index')
            ->with('success', '廣告已成功刪除');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'ads' => 'required|array',
            'ads.*.id' => 'required|exists:home_ads,id',
            'ads.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->ads as $adData) {
            HomeAd::where('id', $adData['id'])
                ->update(['sort_order' => $adData['sort_order']]);
        }

        return response()->json(['message' => '排序已更新']);
    }

    public function toggleActive(HomeAd $homeAd, Request $request)
    {
        $homeAd->update([
            'is_active' => $request->is_active == 'true' ? 1 : 0
        ]);

        return response()->json([
            'success' => true,
            'message' => '狀態更新成功'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdvertController extends Controller
{
    public function index()
    {
        $adverts = Advert::latest()->paginate(15);
        return view('admin.adverts.index', compact('adverts'));
    }

    public function create()
    {
        return view('admin.adverts.create');
    }

    public function edit($id)
    {
        $advert = Advert::findOrFail($id);
        return view('admin.adverts.edit', compact('advert'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
            'url' => 'nullable|url',
            'is_active' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = Str::uuid7() . '.webp';
                $uploadPath = 'adverts/' . $fileName;

                // 使用 Intervention/Image 處理圖片
                $manager = new ImageManager(new Driver());
                $img = $manager->read($image);
                $img->scale(height: 800);
                $img->toWebp(90);

                // 儲存圖片
                Storage::disk('public')->put($uploadPath, $img->encode());
                $validated['image'] = $fileName;
            }

            Advert::create($validated);

            return redirect()->route('admin.adverts.index')
                ->with('success', '廣告已創建');
        } catch (\Exception $e) {
            Log::error('廣告圖片處理失敗：' . $e->getMessage());
            return back()->withErrors(['image' => '圖片處理失敗'])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $advert = Advert::findOrFail($id);

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'image' => 'nullable|image|max:2048',
            'url' => 'nullable|url',
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        try {
            if ($request->hasFile('image')) {
                // 刪除舊圖片
                if ($advert->image) {
                    Storage::disk('public')->delete($advert->image);
                }

                $image = $request->file('image');
                $fileName = Str::uui7() . '.webp';
                $uploadPath = 'adverts/' . $fileName;

                // 使用 Intervention/Image 處理圖片
                $manager = new ImageManager(new Driver());
                $img = $manager->read($image);
                $img->scale(height: 800);
                $img->toWebp(90);

                // 儲存圖片
                Storage::disk('public')->put($uploadPath, $img->encode());
                $validated['image'] = $fileName;
            }

            $advert->update($validated);

            return redirect()->route('admin.adverts.index')
                ->with('success', '廣告已更新');
        } catch (\Exception $e) {
            Log::error('廣告圖片處理失敗：' . $e->getMessage());
            return back()->withErrors(['image' => '圖片處理失敗'])->withInput();
        }
    }

    public function destroy($id)
    {
        $advert = Advert::findOrFail($id);

        // 刪除廣告圖片
        if ($advert->image) {
            Storage::disk('public')->delete($advert->image);
        }

        $advert->delete();

        return redirect()->route('admin.adverts.index')
            ->with('success', '廣告已刪除');
    }

    // 獲取當前活動的廣告 (API 方法保留)
    public function getActiveAdverts()
    {
        $activeAdverts = Advert::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where(function ($query) {
                $query->where('end_date', '>=', now())
                    ->orWhereNull('end_date');
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $activeAdverts
        ]);
    }
}

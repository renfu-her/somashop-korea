<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            try {
                $image = $request->file('upload');
                $fileName = Str::uuid7() . '.webp';
                $uploadPath = 'uploads/' . $fileName;

                // 使用 Intervention/Image 處理圖片
                $manager = new ImageManager(new Driver());
                $img = $manager->read($image);
                // $img->resize(800, null, function ($constraint) {
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });
                $img->toWebp(90);

                // 只儲存一次
                Storage::disk('public')->put($uploadPath, $img->encode());

                return response()->json([
                    'url' => asset('storage/' . $uploadPath),
                    'uploaded' => 1
                ]);
            } catch (\Exception $e) {
                Log::error('圖片上傳失敗：' . $e->getMessage());

                return response()->json([
                    'error' => [
                        'message' => '圖片上傳失敗：' . $e->getMessage()
                    ]
                ], 400);
            }
        }

        return response()->json([
            'error' => [
                'message' => '沒有檔案被上傳'
            ]
        ], 400);
    }
}

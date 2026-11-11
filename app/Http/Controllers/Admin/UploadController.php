<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadCkeditorImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function uploadImage(UploadCkeditorImageRequest $request)
    {
        try {
            $uploadPath = $this->images->uploadCkeditorImage($request->file('upload'));

            return response()->json([
                'url' => asset('storage/' . $uploadPath),
                'uploaded' => 1,
            ]);
        } catch (\Exception $e) {
            Log::error('圖片上傳失敗：' . $e->getMessage());

            return response()->json([
                'error' => [
                    'message' => '圖片上傳失敗：' . $e->getMessage(),
                ],
            ], 400);
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * CKEditor 內文圖片上傳：高度超過 800 才往下縮，不放大、不限制上傳大小。
     */
    public function uploadCkeditorImage(UploadedFile $image, string $path = 'uploads'): string
    {
        $filename = Str::uuid7() . '.webp';
        $fullPath = "{$path}/{$filename}";

        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);

        if ($img->height() > 800) {
            $img->scale(height: 800);
        }

        $encoded = $img->toWebp(quality: 90);

        Storage::disk('public')->put($fullPath, (string) $encoded);

        return $fullPath;
    }

    public function uploadImage(
        UploadedFile $image, 
        string $path, 
        int $width = 800, 
        int $quality = 90
    ): string {
        $filename = Str::uuid7() . '.webp';
        $fullPath = "{$path}/{$filename}";

        if($path === 'ads' || $path === 'home_ads') {
            $width = 1920;
        }

        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);
        $img->scale(width: $width);
        $img->toWebp($quality);

        Storage::disk('public')->put($fullPath, $img->encode());

        return $filename;
    }
}

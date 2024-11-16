<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function uploadImage(
        UploadedFile $image, 
        string $path, 
        int $width = 800, 
        int $quality = 90
    ): string {
        $filename = Str::uuid7() . '.webp';
        $fullPath = "{$path}/{$filename}";

        if($path === 'ads') {
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

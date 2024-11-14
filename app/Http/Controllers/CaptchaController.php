<?php

namespace App\Http\Controllers;

use App\Services\CaptchaService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;

class CaptchaController extends Controller
{
    private $captchaService;

    public function __construct(CaptchaService $captchaService)
    {
        $this->captchaService = $captchaService;
    }

    public function generate()
    {
        $code = $this->captchaService->generateCaptcha();

        $manager = new ImageManager(new Driver());
        $img = $manager->create(120, 40);

        // 設置淺色背景
        $img->fill('#ffffff');

        // 添加干擾線
        for ($i = 0; $i < 6; $i++) {
            $img->drawLine(function ($draw) {
                $draw->from(random_int(0, 120), random_int(0, 40));
                $draw->to(random_int(0, 120), random_int(0, 40));
                // 使用較淺的顏色
                $draw->color('#' . str_pad(dechex(mt_rand(0xCCCCCC, 0xEEEEEE)), 6, '0', STR_PAD_LEFT));
            });
        }

        // 添加文字 - 每個字符單獨處理以增加隨機性
        $length = strlen($code);
        for ($i = 0; $i < $length; $i++) {
            $x = 25 + ($i * 20); // 字符間距
            $y = random_int(20, 30); // 隨機上下位置

            $img->text($code[$i], $x, $y, function ($font) {
                $font->file(public_path('fonts/arial.ttf')); // 使用下載的字體
                $font->size(24);
                $font->color('#000000');
                $font->align('center');
                $font->valign('middle');
            });
        }

        $encoder = new PngEncoder();
        $encodedImage = $img->encode($encoder);

        return response($encodedImage->toString(), 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }
}

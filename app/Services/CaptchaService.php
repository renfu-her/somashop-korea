<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;

class CaptchaService
{
    public function generateCaptcha()
    {
        $code = $this->generateCode();
        $image = $this->generateImage($code);

        session(['captcha_code' => $code]);

        return response($image->toString(), 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    private function generateCode(int $length = 6)
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $code;
    }

    private function generateImage($code)
    {
        $manager = new ImageManager(new Driver());
        $img = $manager->create(140, 60);

        // 設置淺色背景
        $img->fill('#ffffff');

        // 添加干擾線
        for ($i = 0; $i < 6; $i++) {
            $img->drawLine(function ($draw) {
                $draw->from(random_int(0, 180), random_int(0, 40));
                $draw->to(random_int(0, 180), random_int(0, 40));
                // 使用較淺的顏色
                $draw->color('#' . str_pad(dechex(mt_rand(0xCCCCCC, 0xEEEEEE)), 6, '0', STR_PAD_LEFT));
            });
        }

        // 添加文字 - 每個字符單獨處理以增加隨機性
        $length = strlen($code);
        for ($i = 0; $i < $length; $i++) {
            $x = 20 + ($i * 25); // 調整間距以適應字符
            $y = random_int(20, 30); // 隨機上下位置

            $img->text($code[$i], $x, $y, function ($font) {
                $font->file(public_path('fonts/arial.ttf'));
                $font->size(24);
                $font->color('#000000');
                $font->align('center');
                $font->valign('middle');
            });
        }

        return $img->encode(new PngEncoder());
    }

    public function validate($input)
    {
        if (!session()->has('captcha_code')) {
            return false;
        }

        return strtoupper($input) === session('captcha_code');
    }
}

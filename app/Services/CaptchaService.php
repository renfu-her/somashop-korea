<?php

namespace App\Services;

class CaptchaService
{
    
    public function generateCaptcha(int $length = 6)
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ'; // 移除容易混淆的字符
        $code = '';
        
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        return $code;
    }
    
    public function validateCaptcha($input)
    {
        if (!session()->has('captcha_code')) {
            return false;
        }
        
        return strtoupper($input) === session('captcha_code');
    }
} 
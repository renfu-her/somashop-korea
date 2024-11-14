<?php

namespace App\Services;

class CaptchaService
{
    private $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // 排除容易混淆的字符
    
    public function generateCaptcha($length = 4)
    {
        $captcha = '';
        $max = strlen($this->characters) - 1;
        
        for ($i = 0; $i < $length; $i++) {
            $captcha .= $this->characters[random_int(0, $max)];
        }
        
        session(['captcha' => strtoupper($captcha)]);
        return $captcha;
    }
    
    public function validateCaptcha($input)
    {
        if (!session()->has('captcha')) {
            return false;
        }
        
        return strtoupper($input) === session('captcha');
    }
} 
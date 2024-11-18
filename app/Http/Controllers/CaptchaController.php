<?php

namespace App\Http\Controllers;

use App\Services\CaptchaService;

class CaptchaController extends Controller
{
    private $captchaService;

    public function __construct(CaptchaService $captchaService)
    {
        $this->captchaService = $captchaService;
    }

    public function generate()
    {
        return $this->captchaService->generateCaptcha();
    }
}

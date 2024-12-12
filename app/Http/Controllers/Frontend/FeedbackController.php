<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Services\CaptchaService;
use App\Services\MailService;

class FeedbackController extends Controller
{
    protected $captchaService;
    protected $mailService;

    public function __construct(
        CaptchaService $captchaService,
        MailService $mailService
    ) {
        $this->captchaService = $captchaService;
        $this->mailService = $mailService;
    }

    public function index()
    {
        return view('frontend.feedback.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required',
            'captcha' => 'required|min:5',
        ]);

        // 驗證驗證碼
        if (!$this->captchaService->validate($request->captcha)) {
            return $this->error('驗證碼不正確');
        }

        unset($request['captcha']);

        Feedback::create($request->all());

        $this->mailService->sendFeedbackMail($request->email, $request->message);

        return $this->success('留言成功，感謝您的回饋');
    }
}

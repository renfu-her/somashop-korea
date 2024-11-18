<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MailService;
use App\Models\Member;

class TestController extends Controller
{

    protected $captchaService;
    protected $mailService;

    public function __construct(
        MailService $mailService
    ) {
        $this->mailService = $mailService;
    }
    public function test(MailService $mailService)
    {

        $member = Member::where('email', 'renfu.her@gmail.com')->first();
        $this->mailService->send(
            $member->email,
            '歡迎加入會員',
            [
                'title' => '歡迎加入',
                'content' => "親愛的 {$member->name} 您好，\n\n感謝您加入我們的會員...",
                'button' => [
                    'text' => '購物網站，您可以開始購物了！',
                    'url' => route('home')
                ]
            ],
            'emails.content',
            ['member' => $member]
        );
    }
}

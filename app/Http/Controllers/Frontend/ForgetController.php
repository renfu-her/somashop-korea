<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Services\MailService;

class ForgetController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function forget()
    {
        return view('frontend.login.forget');
    }

    public function forgetProcess(Request $request)
    {
        // 验证验证码
        if ($request->captcha != session('captcha_code')) {
            return redirect()->back()->with('error', '驗證碼錯誤');
        }

        // 查找用户
        $member = Member::where('email', $request->email)->first();
        if (!$member) {
            return redirect()->back()->with('error', '找不到此電子郵件地址');
        }

        // 生成新密码
        $newPassword = Str::random(8);
        
        // 更新用户密码
        $member->password = Hash::make($newPassword);
        $member->save();

        // 使用 MailService 發送郵件
        $this->mailService->send(
            $member->email,
            'EzHive 易群佶選購物車 - 密碼重置通知',
            [
                'title' => '密碼重置通知',
                'content' => "親愛的 {$member->name} 您好，\n\n您的新密碼是：{$newPassword}\n\n請盡快登入並修改密碼。",
                'button' => [
                    'text' => '前往登入',
                    'url' => route('login')
                ]
            ],
            'emails.forget-password',
            [
                'member' => $member->toArray(),
                'password' => $newPassword
            ]
        );

        return redirect()->route('login')->with('success', '新密碼已發送至您的郵箱');
    }
}

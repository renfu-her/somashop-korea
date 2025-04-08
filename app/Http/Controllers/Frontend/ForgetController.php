<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ForgetController extends Controller
{
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

        // 发送邮件
        $emailData = [
            'name' => $member->name,
            'password' => $newPassword
        ];

        Mail::send('emails.forget-password', $emailData, function($message) use ($member) {
            $message->to($member->email)
                   ->subject('EzHive 易群佶選購物車 - 密碼重置通知');
        });

        return redirect()->route('login')->with('success', '新密碼已發送至您的郵箱');
    }
}

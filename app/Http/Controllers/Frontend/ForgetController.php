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
        // 인증번호 확인
        if ($request->captcha != session('captcha_code')) {
            return redirect()->back()->with('error', '인증번호가 잘못되었습니다');
        }

        // 사용자 찾기
        $member = Member::where('email', $request->email)->first();
        if (!$member) {
            return redirect()->back()->with('error', '해당 이메일 주소를 찾을 수 없습니다');
        }

        // 새 비밀번호 생성
        $newPassword = Str::random(8);
        
        // 사용자 비밀번호 업데이트
        $member->password = Hash::make($newPassword);
        $member->save();

        // MailService를 사용하여 이메일 발송
        $this->mailService->send(
            $member->email,
            'SOMA SHOP - 비밀번호 재설정 안내',
            [
                'title' => '비밀번호 재설정 안내',
                'content' => "안녕하세요 {$member->name}님,\n\n새로운 비밀번호는 다음과 같습니다：{$newPassword}\n\n빠른 시일 내에 로그인하여 비밀번호를 변경해주세요.",
                'button' => [
                    'text' => '로그인하기',
                    'url' => route('login')
                ]
            ],
            'emails.forget-password',
            [
                'member' => $member->toArray(),
                'password' => $newPassword
            ]
        );

        return redirect()->route('login')->with('success', '새로운 비밀번호가 이메일로 발송되었습니다');
    }
}

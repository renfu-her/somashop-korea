<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use App\Services\CaptchaService;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\MailService;

class JoinController extends Controller
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
        return view('frontend.join.index');
    }

    public function joinProcess(Request $request)
    {
        // 表單驗證規則
        $validated = $request->validate([
            'email' => 'required|email|unique:members,email',
            'password' => 'required|min:6|max:15|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)/',
            'name' => 'required|string|max:50',
            'gender' => 'required|in:1,2',
            'year' => 'numeric|min:1900|max:' . date('Y'),
            'month' => 'numeric|min:1|max:12',
            'day' => 'numeric|min:1|max:31',
            'phone' => 'required|regex:/^09\d{8}$/',
            'county' => 'required|string',
            'district' => 'required|string',
            'address' => 'required|string',
            'captcha' => 'required',
            'agree' => 'required|accepted',
        ], [
            'agree.required' => '請同意會員條款',
            'agree.accepted' => '請同意會員條款',
        ]);

        // 驗證驗證碼
        if (!$this->captchaService->validate($request->captcha)) {
            return $this->error('驗證碼不正確');
        }

        // 驗證生日
        $birthday = $this->validateBirthday($request);
        if (is_string($birthday) && str_contains($birthday, 'error:')) {
            return $this->error(str_replace('error:', '', $birthday));
        }

        // 創建會員
        $member = Member::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'gender' => $request->gender,
            'birthday' => $birthday,
            'phone' => $request->phone,
            'county' => $request->county,
            'district' => $request->district,
            'address' => $request->address,
            'zipcode' => $request->zipcode,
            'status' => 1,
            'email_verified_at' => now(),
        ]);

        // 發送歡迎郵件 - 使用通用方法
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

        return $this->success('註冊成功！歡迎加入我們', 'home');
    }

    /**
     * 驗證生日
     */
    private function validateBirthday(Request $request)
    {
        if ($request->year || $request->month || $request->day) {
            if (!$request->year || !$request->month || !$request->day) {
                return 'error:如果要填寫生日，請填寫完整的年月日';
            }

            if (!checkdate($request->month, $request->day, $request->year)) {
                return 'error:請輸入有效的出生日期';
            }

            return sprintf('%04d-%02d-%02d', $request->year, $request->month, $request->day);
        }

        return null;
    }
}

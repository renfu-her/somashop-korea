<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\CaptchaService;

class AdminAuthController extends Controller
{
    protected $captchaService;

    public function __construct(CaptchaService $captchaService)
    {
        $this->captchaService = $captchaService;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // 驗證基本資料
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required'
        ], [
            'captcha.required' => '請輸入驗證碼'
        ]);

        // 驗證驗證碼
        if (!$this->captchaService->validate($request->captcha)) {
            return back()
                ->withErrors(['captcha' => '驗證碼不正確'])
                ->withInput($request->only('email'));
        }

        // 移除驗證碼，因為不是登入憑證
        unset($credentials['captcha']);

        // 添加 is_admin 條件
        $credentials['is_admin'] = true;

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // 更新最後登入時間
            User::find(Auth::user()->id)->update([
                'last_login_at' => now()
            ]);

            $request->session()->regenerate();
            return redirect()->intended('/admin/products');
        }

        return back()
            ->withErrors([
                'email' => '登入資訊不正確或您沒有管理員權限。',
            ])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}

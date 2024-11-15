<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class JoinController extends Controller
{
    public function index()
    {
        return view('frontend.join.index');
    }

    public function joinProcess(Request $request)
    {
        // 驗證驗證碼
        if (session('captcha_code') !== $request->captcha) {
            return back()->withErrors(['captcha' => '驗證碼不正確'])->withInput();
        }

        try {
            // 處理生日
            $birthday = sprintf(
                '%04d-%02d-%02d',
                $request->year,
                $request->month,
                $request->day
            );

            // 創建用戶
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'name' => $request->name,
                'gender' => $request->gender,
                'birthday' => $birthday,
                'phone' => $request->phone,
                'county' => $request->county,
                'district' => $request->district,
                'address' => $request->address,
            ]);

            // 註冊成功後的處理
            return redirect()->route('join.success');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => '註冊失敗，請稍後再試'])->withInput();
        }
    }
}

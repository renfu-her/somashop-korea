<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        return view('frontend.login.index');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('member')->attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->has('redirect_to')) {
                return redirect($request->redirect_to);
            }
            
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => '帳號或密碼錯誤',
        ])->withInput();
    }

    public function logout()
    {
        Auth::guard('member')->logout();
        session()->forget('cart');
        return redirect()->route('home');
    }

    public function forget()
    {
        return view('frontend.login.forget');
    }

    public function forgetProcess(Request $request)
    {
        dd($request->all());
    }
}

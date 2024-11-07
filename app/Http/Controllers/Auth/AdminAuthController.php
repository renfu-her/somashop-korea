<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    protected $middleware = [
        'guest:admin' => ['except' => ['logout']]
    ];

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // 添加 is_admin 條件
        $credentials['is_admin'] = true;
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/notes');
        }
        
        return back()->withErrors([
            'email' => '登入資訊不正確或您沒有管理員權限。',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}

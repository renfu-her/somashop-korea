<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        return view('frontend.login.index');
    }

    public function loginProcess(Request $request)
    {
        dd($request->all());
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}

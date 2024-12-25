<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();
        return view(
            'frontend.profile.index',
            compact('member')
        );
    }

    public function update(Request $request)
    {
        
        $member = Member::find(Auth::guard('member')->user()->id);
        
        if (!$member) {
            return $this->error('使用者不存在');
        }

        if ($request->password != $request->password_confirm) {
            return $this->error('密碼與確認密碼不相符');
        }

        $member->password = Hash::make($request->password);
        $member->county = $request->county;
        $member->district = $request->district;
        $member->address = $request->address;
        $member->zipcode = $request->zipcode;
        $member->phone = $request->phone;
        $member->save();
        
        return redirect()->route('profile.index')->with('success', '資料更新成功');
    }
}

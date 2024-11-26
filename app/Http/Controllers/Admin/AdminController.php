<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('is_admin', true)->latest()->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'is_admin' => ['boolean'],
            'permissions' => ['array'], // 權限設定
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = true; // 設定為管理者

        User::create($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', '管理者創建成功！');
    }

    public function edit(User $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        // 處理密碼
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // 處理 is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $admin->update($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', '管理者資料更新成功！');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', '無法刪除當前登入的管理者帳號！');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', '管理者已刪除！');
    }

    public function toggleStatus(User $admin, Request $request)
    {

        $admin->update([
            'is_active' => $request->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => '狀態更新成功'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSetting;
use Illuminate\Http\Request;

class EmailSettingController extends Controller
{
    public function index()
    {
        $emailSettings = EmailSetting::orderBy('id', 'desc')->get();
        return view('admin.email-settings.index', compact('emailSettings'));
    }

    public function create()
    {
        return view('admin.email-settings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'is_active' => 'boolean'
        ]);

        // 確保 is_active 有值
        $validated['is_active'] = $request->has('is_active');

        EmailSetting::create($validated);

        return redirect()
            ->route('admin.email-settings.index')
            ->with('success', '郵件設定已成功創建');
    }

    public function edit(EmailSetting $emailSetting)
    {
        return view('admin.email-settings.edit', compact('emailSetting'));
    }

    public function update(Request $request, EmailSetting $emailSetting)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'is_active' => 'boolean'
        ]);

        // 確保 is_active 有值
        $validated['is_active'] = $request->has('is_active');

        $emailSetting->update($validated);

        return redirect()
            ->route('admin.email-settings.index')
            ->with('success', '郵件設定已成功更新');
    }

    public function destroy(EmailSetting $emailSetting)
    {
        $emailSetting->delete();

        return redirect()
            ->route('admin.email-settings.index')
            ->with('success', '郵件設定已成功刪除');
    }
} 
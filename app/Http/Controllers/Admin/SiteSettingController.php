<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first();
        return view('admin.site-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $settings = SiteSetting::firstOrNew();
        
        // 更新其他欄位
        $settings->fill($request->except(['logo', 'favicon']));
        $settings->save();

        return redirect()->route('admin.site-settings.index')->with('success', '設定已更新');
    }
} 
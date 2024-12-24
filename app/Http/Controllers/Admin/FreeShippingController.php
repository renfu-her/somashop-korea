<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreeShipping;
use Illuminate\Http\Request;

class FreeShippingController extends Controller
{
    public function index()
    {
        $freeShippings = FreeShipping::latest()->paginate(10);
        return view('admin.free-shippings.index', compact('freeShippings'));
    }

    public function create()
    {
        return view('admin.free-shippings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'minimum_amount' => 'required|numeric|min:0',
        ]);

        FreeShipping::create($validated);

        return redirect()->route('admin.free-shippings.index')
            ->with('success', '免運費設定已成功創建！');
    }

    public function edit(FreeShipping $freeShipping)
    {
        return view('admin.free-shippings.edit', compact('freeShipping'));
    }

    public function update(Request $request, FreeShipping $freeShipping)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'minimum_amount' => 'required|numeric|min:0',
        ]);

        $freeShipping->update($validated);

        return redirect()->route('admin.free-shippings.index')
            ->with('success', '免運費設定已成功更新！');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        return view('frontend.activity.index');
    }

    public function detail($id)
    {
        return view('frontend.activity.detail', compact('id'));
    }
}

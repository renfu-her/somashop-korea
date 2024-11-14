<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {

        $activities = Activity::orderByDesc('created_at')->get();

        return view('frontend.activity.index', compact('activities'));
    }

    public function detail($id)
    {
        return view('frontend.activity.detail', compact('id'));
    }
}

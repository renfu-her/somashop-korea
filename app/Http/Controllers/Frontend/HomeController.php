<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class HomeController extends Controller
{
    public function index()
    {

        $actives = Activity::orderByDesc('id')
            ->get();

        return view('frontend.home', compact('actives'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JoinController extends Controller
{
    public function index()
    {
        return view('frontend.join.index');
    }

    public function joinProcess(Request $request)
    {
        dd($request->all());
    }
}

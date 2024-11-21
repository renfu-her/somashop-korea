<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $products = Product::query()
            ->where('is_active', true)
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('sub_title', 'like', "%{$search}%");
            })
            ->with('primaryImage')
            ->paginate(12);
        
        return view('frontend.search.index', compact('products'));
    }
} 
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index($id)
    {
        // 獲取當前分類
        $currentCategory = Category::with('parent')->find($id);

        // 獲取所有頂層分類及其子分類
        $categories = Category::where('parent_id', 0)
            ->with(['children' => function ($query) {
                $query->orderBy('name');
                $query->with(['children' => function ($q) {
                    $q->orderBy('name');
                }]);
            }])
            ->orderBy('name')
            ->get();

        // 獲取當前分類的產品
        $products = Product::where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('frontend.product', compact(
            'currentCategory',
            'categories',
            'products'
        ));
    }
}

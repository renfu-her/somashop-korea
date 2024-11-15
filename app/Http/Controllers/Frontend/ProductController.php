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

        // 獲取當前分類的產品，並確保加載主圖
        $products = Product::where('category_id', $id)
            ->with('primaryImage')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('frontend.product.index', compact(
            'currentCategory',
            'categories',
            'products'
        ));
    }

    public function show($id)
    {

        // 獲取產品詳細信息，包括分類、主圖和所有圖片
        $product = Product::with(['category.parent', 'primaryImage', 'images'])
            ->findOrFail($id);

        // 獲取所有頂層分類及其子分類（用於側邊欄）
        $categories = Category::where('parent_id', 0)
            ->with(['children' => function ($query) {
                $query->orderBy('name');
                $query->with(['children' => function ($q) {
                    $q->orderBy('name');
                }]);
            }])
            ->orderBy('name')
            ->get();

        $currentCategory = $product->category;


        return view('frontend.product.detail', compact(
            'product',
            'categories',
            'currentCategory'
        ));
    }
}

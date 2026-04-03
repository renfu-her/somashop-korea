<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FreeShipping;
use App\Models\Product;

class ProductController extends Controller
{
    public function index($id)
    {
        $currentCategory = Category::with('parent')->find($id);
        $categories = Category::getFrontendNavigationTree();

        $products = Product::where('category_id', $id)
            ->where('is_active', 1)
            ->with('primaryImage')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('frontend.product.index', compact(
            'currentCategory',
            'categories',
            'products'
        ));
    }

    public function show($id)
    {
        $product = Product::where('is_active', 1)
            ->with(['category.parent', 'primaryImage', 'images', 'specs'])
            ->findOrFail($id);

        $categories = Category::getFrontendNavigationTree();
        $currentCategory = $product->category;

        $freeShippings = FreeShipping::where('is_active', 1)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('start_date')
                        ->whereNull('end_date');
                })->orWhere(function ($q) {
                    $q->whereNotNull('start_date')
                        ->whereNotNull('end_date')
                        ->where('start_date', '<=', now())
                        ->where('end_date', '>=', now());
                });
            })
            ->orderBy('minimum_amount', 'desc')
            ->first();

        return view('frontend.product.detail', compact(
            'product',
            'categories',
            'currentCategory',
            'freeShippings'
        ));
    }
}

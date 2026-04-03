<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FaqCategory;
use App\Models\Post;
use App\Models\SealKnowledgeCategory;

class NavigationController extends Controller
{
    public function getNavigationData()
    {
        $data = [
            'about' => $this->getAboutPages(),
            'categories' => $this->getProductCategories(),
            'faqCategories' => $this->getFaqCategories(),
            'sealKnowledgeCategories' => $this->getSealKnowledgeCategories(),
        ];

        $cartItems = session('cart', []);
        $cartCount = is_array($cartItems) ? count($cartItems) : 0;

        return [
            'about' => $data['about'],
            'categories' => $data['categories'],
            'faqCategories' => $data['faqCategories'],
            'sealKnowledgeCategories' => $data['sealKnowledgeCategories'],
            'cartCount' => $cartCount,
        ];
    }

    private function getAboutPages()
    {
        return Post::orderBy('sort_order', 'asc')->get();
    }

    private function getProductCategories()
    {
        return Category::getFrontendNavigationTree();
    }

    private function getSealKnowledgeCategories()
    {
        return SealKnowledgeCategory::where('status', true)
            ->orderBy('sort')
            ->get();
    }

    private function getFaqCategories()
    {
        return FaqCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function getCartCount()
    {
        $cartItems = session('cart', []);
        $cartCount = is_array($cartItems) ? count($cartItems) : 0;

        return response()->json(['count' => $cartCount]);
    }
}

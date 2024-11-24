<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Article;
use App\Models\Faq;
use App\Models\FaqCategory;
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

        // 獲取購物車數量
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
        // 獲取主分類（parent_id = 0）及其子分類
        $categories = Category::where('parent_id', 0)
            ->with(['children' => function ($query) {
                $query->with('children'); // 獲取第三層分類
            }])
            ->get();

        return $categories;
    }

    private function getSealKnowledgeCategories()
    {
        $sealKnowledgeCategories = SealKnowledgeCategory::where('status', true)
            ->orderBy('sort')
            ->get();

        return $sealKnowledgeCategories;
    }

    private function getFaqCategories()
    {
        $faqCategories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return $faqCategories;
    }
}

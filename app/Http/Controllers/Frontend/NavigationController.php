<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Article;
use App\Models\Faq;
use App\Models\FaqCategory;

class NavigationController extends Controller
{
    public function getNavigationData()
    {
        $data = [
            'about' => $this->getAboutPages(),
            'categories' => $this->getProductCategories(),
            'articles' => $this->getArticleCategories(),
            'faqCategories' => $this->getFaqCategories(),
        ];

        return $data;
    }

    private function getAboutPages()
    {
        return Post::all();
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

    private function getArticleCategories()
    {
        return ['印章的秘密', '印章材質介紹', '印章保養方法', '印章字體介紹', '剃胎毛/胎毛筆', '產品介紹', '服務介紹'];
    }

    private function getFaqCategories()
    {
        $faqCategories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return $faqCategories;
    }
}

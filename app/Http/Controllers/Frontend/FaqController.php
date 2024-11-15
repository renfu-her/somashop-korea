<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index($categoryId = null)
    {
        // 獲取所有啟用的FAQ分類
        $categories = FaqCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
            
        // 如果沒有指定分類，使用第一個分類
        if (!$categoryId && $categories->isNotEmpty()) {
            $categoryId = $categories->first()->id;
        }
        
        // 獲取當前分類的FAQ列表
        $faqs = Faq::where('category_id', $categoryId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
            
        return view('frontend.faqs.index', compact('categories', 'faqs', 'categoryId'));
    }
} 
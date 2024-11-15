<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SealKnowledge;
use App\Models\SealKnowledgeCategory;
use Illuminate\Http\Request;

class SealKnowledgeCategoryController extends Controller
{
    public function show($id)
    {
        $categories = SealKnowledgeCategory::where('status', true)
            ->orderBy('sort')
            ->get();

        $currentCategory = $categories->firstWhere('id', $id);

        $knowledges = SealKnowledge::where('category_id', $currentCategory->id)
            ->where('status', true)
            ->orderBy('sort')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.seal-knowledge.index', compact(
            'categories',
            'currentCategory',
            'knowledges'
        ));
    }
}

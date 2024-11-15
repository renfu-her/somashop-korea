<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SealKnowledge;
use App\Models\SealKnowledgeCategory;
use Illuminate\Http\Request;

class SealKnowledgeController extends Controller
{
    public function index()
    {
        $categories = SealKnowledgeCategory::where('status', true)
            ->orderBy('sort')
            ->get();

        $currentCategory = $categories->first();
        
        if (!$currentCategory) {
            abort(404);
        }

        return $this->category($currentCategory->id);
    }

    public function category($id)
    {
        $categories = SealKnowledgeCategory::where('status', true)
            ->orderBy('sort')
            ->get();

        $currentCategory = $categories->firstWhere('id', $id);
        
        if (!$currentCategory) {
            abort(404);
        }

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

    public function show($id)
    {
        $knowledge = SealKnowledge::where('status', true)->findOrFail($id);
        $categories = SealKnowledgeCategory::where('status', true)
            ->orderBy('sort')
            ->get();
        $currentCategory = $knowledge->category;

        return view('frontend.seal-knowledge.detail', compact(
            'categories',
            'currentCategory',
            'knowledge'
        ));
    }
} 
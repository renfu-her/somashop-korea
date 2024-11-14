<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::orderByDesc('created_at')->get();
        return view('frontend.activity.index', compact('activities'));
    }

    public function detail($id)
    {
        $activity = Activity::findOrFail($id);
        
        // 使用正則表達式處理圖片標籤
        $activityContent = preg_replace(
            '/<img(.*?)width="[^"]*"(.*?)height="[^"]*"(.*?)>/',
            '<img$1$2$3 style="width: 100%; height: auto;">',
            $activity->content
        );

        $activityTitle = $activity->title;

        return view('frontend.activity.detail', compact(
            'activityContent',
            'activity',
            'activityTitle'
        ));
    }
}

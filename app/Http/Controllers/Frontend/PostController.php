<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return view('frontend.posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::find($id);
        $posts = Post::orderBy('sort_order', 'asc')->get();

        // 使用正則表達式處理圖片標籤
        $postContent = preg_replace(
            '/<img(.*?)width="[^"]*"(.*?)height="[^"]*"(.*?)>/',
            '<img$1$2$3 style="width: 100%; height: auto;">',
            $post->content
        );

        $postTitle = $post->title;

        return view(
            'frontend.post',
            compact('postContent', 'posts', 'postTitle')
        );
    }
}

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
        $posts = Post::get();

        return view('frontend.post', compact('post', 'posts'));
    }
}

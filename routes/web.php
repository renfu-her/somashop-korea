<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\ProductController;
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');
Route::get('/product/{id}', [ProductController::class, 'index'])->name('product.index');

// 產品分類路由
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('category/{id}', [App\Http\Controllers\Frontend\ProductController::class, 'index'])
        ->name('category');
    Route::get('show/{id}', [App\Http\Controllers\Frontend\ProductController::class, 'show'])
        ->name('show');
});



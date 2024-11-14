<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\JoinController;

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::get('/join', [JoinController::class, 'index'])->name('join');
Route::post('/join', [JoinController::class, 'joinProcess'])->name('join.process');

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

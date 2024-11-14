<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\JoinController;
use App\Http\Controllers\Frontend\ActivityController;
use App\Http\Controllers\CaptchaController;

// 首頁路由
Route::get('/', [HomeController::class, 'index'])->name('home');

// 登入路由
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

// 註冊路由
Route::get('/join', [JoinController::class, 'index'])->name('join');
Route::post('/join', [JoinController::class, 'joinProcess'])->name('join.process');


// 忘記密碼路由
Route::get('/forget', [LoginController::class, 'forget'])->name('forget');
Route::post('/forget', [LoginController::class, 'forgetProcess'])->name('forget.process');

// 文章路由
Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');

// 產品路由
Route::get('/product/{id}', [ProductController::class, 'index'])->name('product.index');

// 活動訊息路由
Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
Route::get('/activity/{id}', [ActivityController::class, 'detail'])->name('activity.detail');


// 產品分類路由
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('category/{id}', [App\Http\Controllers\Frontend\ProductController::class, 'index'])
        ->name('category');
    Route::get('show/{id}', [App\Http\Controllers\Frontend\ProductController::class, 'show'])
        ->name('show');
});

Route::get('/captcha', [CaptchaController::class, 'generate'])->name('captcha.generate');

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
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\SealKnowledgeController;
use App\Http\Controllers\Frontend\SealKnowledgeCategoryController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;

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

// 常見問題路由
Route::get('/faqs/{category?}', [FaqController::class, 'index'])->name('faqs.index');

// 產品分類路由
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('category/{id}', [ProductController::class, 'index'])
        ->name('category');
    Route::get('show/{id}', [ProductController::class, 'show'])
        ->name('show');
});

// 印章知識路由
Route::group(['prefix' => 'seal-knowledge', 'as' => 'seal-knowledge.'], function () {
    Route::get('/', [SealKnowledgeController::class, 'index'])->name('index');
    Route::get('/category/{id}', [SealKnowledgeCategoryController::class, 'show'])->name('category');
    Route::get('/{id}', [SealKnowledgeController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('show');
});

// 驗證碼路由
Route::get('/captcha', [CaptchaController::class, 'generate'])->name('captcha.generate');

// 購物車和結帳路由
Route::group(['middleware' => 'auth'], function () {
    // 購物車
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');

    // 結帳流程
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    // 訂單
    Route::post('/orders/{product}', [OrderController::class, 'store'])->name('products.order');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

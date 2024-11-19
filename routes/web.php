<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\JoinController;
use App\Http\Controllers\Frontend\ActivityController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\{
    SealKnowledgeController,
    SealKnowledgeCategoryController
};
use App\Http\Controllers\Frontend\{
    CartController,
    CheckoutController,
    PaymentController,
    OrderController
};

use App\Http\Controllers\Frontend\TestController;

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

// 登出路由
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

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
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('category/{id}', [ProductController::class, 'index'])->name('category');
    Route::get('show/{id}', [ProductController::class, 'show'])->name('show');
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
Route::post('/captcha/refresh', [CaptchaController::class, 'generate'])->name('captcha.refresh');

// 購物車和結帳路由
Route::group(['middleware' => 'auth:member'], function () {
    // 購物車
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    // Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    // Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');

    // 需要添加的路由
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');

    // 結帳流程
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'addToCart'])->name('checkout.add');

    // 結帳驗證
    Route::post('/payment/process', [PaymentController::class, 'paymentProcess'])->name('payment.process');
      // 訂單
    Route::post('/orders/{product}', [OrderController::class, 'store'])->name('products.order');
    Route::get('/orders/list/{order}', [OrderController::class, 'orderShow'])->name('orders.show');
    Route::get('/orders/list', [OrderController::class, 'orderList'])->name('orders.list');
});


// 付款結果
Route::post('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
Route::get('/payment/notify', [PaymentController::class, 'notify'])->name('payment.notify');

// 門市地圖
Route::get('/checkout/map/711-store/{shippmentType}', [CheckoutController::class, 'openSevenMap'])->name('checkout.map.711');
Route::get('/checkout/map/family-store/{shippmentType}', [CheckoutController::class, 'openFamilyMap'])->name('checkout.map.family');

// 重寫門市地圖
Route::post('/checkout/map/rewrite', [CheckoutController::class, 'rewriteMap'])->name('checkout.map.rewrite');
// 獲取已選擇的門市資訊
Route::get('/checkout/get-store', [CheckoutController::class, 'getSelectedStore'])->name('checkout.get.store');



// TODO: 測試路由，記得刪除
Route::group(['prefix' => 'tester', 'as' => 'tester.'], function () {
    Route::get('/mail', [TestController::class, 'test'])->name('test');
});

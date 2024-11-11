<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminNoteController;
use App\Http\Controllers\Admin\AdvertController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqCategoryController;

// 管理員登入
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('post.login');
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');
});


Route::group([
    'middleware' => ['admin.auth'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    // Route::resource('categories', AdminCategoryController::class);
    Route::resource('notes', AdminNoteController::class);
    Route::resource('adverts', AdvertController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('carts', CartController::class);
    Route::resource('products', ProductController::class);
    Route::resource('adverts', AdvertController::class);
    Route::post('upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');

    // 產品圖片相關路由
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        // 更新圖片排序
        Route::post('{product}/images/order', [ProductImageController::class, 'updateOrder'])->name('images.order');
        // 設置主圖
        Route::post('{product}/images/{image}/primary', [ProductImageController::class, 'setPrimary'])->name('images.primary');
        // 刪除圖片
        Route::delete('{product}/images/{image}', [ProductImageController::class, 'destroy'])->name('images.destroy');
    });

    Route::resource('faqs', FaqController::class);
    Route::resource('faq-categories', FaqCategoryController::class);
});

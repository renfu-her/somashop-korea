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
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SealKnowledgeController;
use App\Http\Controllers\Admin\SealKnowledgeCategoryController;
use App\Http\Controllers\Admin\ProductSpecificationController;
use App\Http\Controllers\Admin\AdController;
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
    // Route::resource('notes', AdminNoteController::class);

    // 廣告管理     
    Route::resource('ads', AdController::class)->except(['show']);

    // 分類管理
    Route::resource('categories', CategoryController::class);

    // 購物車管理
    Route::resource('carts', CartController::class);

    // 產品管理
    Route::resource('products', ProductController::class);
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

    // 常見問題管理
    Route::resource('faqs', FaqController::class);
    Route::resource('faq-categories', FaqCategoryController::class);

    // 活動管理
    Route::resource('activities', ActivityController::class);

    // 會員管理
    Route::resource('members', MemberController::class);

    // 管理員管理
    Route::resource('admins', AdminController::class);
    Route::resource('admins', AdminController::class);

    // 文章管理
    Route::resource('posts', PostController::class);

    // 印章知識文章路由
    Route::resource('seal-knowledge', SealKnowledgeController::class);
    Route::post('seal-knowledge/update-sort', [SealKnowledgeController::class, 'updateSort'])
        ->name('seal-knowledge.update-sort');
    Route::post('seal-knowledge/{knowledge}/toggle-status', [SealKnowledgeController::class, 'toggleStatus'])
        ->name('seal-knowledge.toggle-status');

    // 印章知識分類路由
    Route::resource('seal-knowledge-category', SealKnowledgeCategoryController::class);
    Route::post('seal-knowledge-category/update-sort', [SealKnowledgeCategoryController::class, 'updateSort'])
        ->name('seal-knowledge-category.update-sort');
    Route::post('seal-knowledge-category/{category}/toggle-status', [SealKnowledgeCategoryController::class, 'toggleStatus'])
        ->name('seal-knowledge-category.toggle-status');
    Route::get('seal-knowledge-category/active/list', [SealKnowledgeCategoryController::class, 'getActiveCategories'])
        ->name('seal-knowledge-category.active');

    // 規格管理
    Route::resource('specifications', ProductSpecificationController::class);
});

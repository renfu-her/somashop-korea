<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminNoteController;
use App\Http\Controllers\Admin\AdvertController;
use App\Http\Controllers\Admin\{
    AdminController,
    ActivityController,
    AdController,
    CartController,
    CategoryController,
    OrderController,
    ProductController,
    ProductImageController,
    ProductSpecificationController,
    PostController,
    EmailSettingController,
    SettingController,
    ProductSpecController,
    UploadController,
    FaqController,
    FaqCategoryController,
    SealKnowledgeCategoryController,
    SealKnowledgeController,
    MemberController,
    HomeAdsController,
};


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
    Route::post('activities/{activity}/sort', [ActivityController::class, 'updateSort'])->name('activities.sort');
    Route::post('activities/{activity}/toggle-active', [ActivityController::class, 'toggleActive'])->name('activities.toggle-active');

    // 會員管理
    Route::resource('members', MemberController::class);

    // 管理員管理
    Route::resource('admins', AdminController::class);
    Route::resource('admins', AdminController::class);

    // 關於我們管理
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

    // 郵件設定
    Route::resource('email-settings', EmailSettingController::class);

    // 系統設定
    Route::resource('settings', SettingController::class);

    // 產品規格管理
    Route::resource('products.specs', ProductSpecController::class)->except(['show']);
    Route::post('products/{product}/specs/{spec}/toggle-active', [ProductSpecController::class, 'toggleActive'])
        ->name('products.specs.toggle-active');

    // 訂單管理
    Route::resource('orders', OrderController::class);

    // 首頁廣告管理
    Route::resource('home-ads', HomeAdsController::class)->except(['show']);
    Route::post('home-ads/update-order', [HomeAdsController::class, 'updateOrder'])->name('home-ads.update-order');

    // 廣告狀態切換
    Route::post('ads/{ad}/toggle-active', [AdController::class, 'toggleActive'])
        ->name('admin.ads.toggle-active');

    // 首頁小廣告狀態切換
    Route::post('home-ads/{homeAd}/toggle-active', [HomeAdsController::class, 'toggleActive'])
        ->name('admin.home-ads.toggle-active');

    // FAQ 分類狀態切換
    Route::post('faq-categories/{category}/toggle-active', [FaqCategoryController::class, 'toggleActive'])
        ->name('admin.faq-categories.toggle-active');

    // FAQ 狀態切換
    Route::post('faqs/{faq}/toggle-active', [FaqController::class, 'toggleActive'])
        ->name('admin.faqs.toggle-active');
});

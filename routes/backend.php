<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminNoteController;
use App\Http\Controllers\Admin\AdvertController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

// 管理員登入
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');
});


Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    // Route::resource('categories', AdminCategoryController::class);
    Route::resource('notes', AdminNoteController::class);
    Route::resource('adverts', AdvertController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('carts', CartController::class);
    Route::resource('products', ProductController::class);
});

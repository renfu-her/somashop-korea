<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;

// // 管理員登入
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Route::prefix('backend')->name('backend.')->group(function () {
//     Route::get('/', function () {
//         return 'Hello World';
//     });
// });

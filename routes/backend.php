<?php

use Illuminate\Support\Facades\Route;

Route::prefix('backend')->name('backend.')->group(function () {
    Route::get('/', function () {
        return 'Hello World';
    });
});

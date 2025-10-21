<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SanPhamController;

Route::get('/', function () {
    return view('welcome');
});


// Đặt các route admin vào một nhóm để dễ quản lý
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('san_pham', SanPhamController::class);
});
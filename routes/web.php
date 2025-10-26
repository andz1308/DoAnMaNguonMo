<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\HomeController;

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/products/by-brand', [HomeController::class, 'productsByBrand'])->name('products.by-brand');
Route::get('/products/by-category/{categoryId}', [HomeController::class, 'productsByCategory'])->name('products.by-category');
Route::get('/products/{id}', [HomeController::class, 'show'])->name('products.show');

// Đặt các route admin vào một nhóm để dễ quản lý
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('san-pham', SanPhamController::class);
});
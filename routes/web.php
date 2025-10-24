<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\User\UsersController;

Route::get('/', function () {
    return view('welcome');
});

// --- Routes cho Đăng ký ---
Route::get('/register', [UsersController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UsersController::class, 'register']);

// --- Routes cho Đăng nhập ---
Route::get('/login', [UsersController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UsersController::class, 'login']);

// --- Route cho Đăng xuất ---
Route::post('/logout', [UsersController::class, 'logout'])->name('logout');


// Đặt các route admin vào một nhóm để dễ quản lý
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('san_pham', SanPhamController::class);
});
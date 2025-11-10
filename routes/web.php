<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\Admin\ImagesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\ReportController;

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/products/by-brand', [HomeController::class, 'productsByBrand'])->name('products.by-brand');
Route::get('/products/by-category/{categoryId}', [HomeController::class, 'productsByCategory'])->name('products.by-category');
Route::get('/products/{id}', [HomeController::class, 'show'])->name('products.show');


// --- Routes cho Đăng ký ---
Route::get('/register', [UsersController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UsersController::class, 'register']);

// --- Routes cho Đăng nhập ---
Route::get('/login', [UsersController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UsersController::class, 'login']);

// --- Route cho Đăng xuất ---
Route::post('/logout', [UsersController::class, 'logout'])->name('logout');



// // Đặt các route admin vào một nhóm để dễ quản lý
// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::resource('san_pham', SanPhamController::class);
// });


// Đặt các route admin vào một nhóm để dễ quản lý
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UsersController::class);
    Route::post('users/{id}/toggle-status', [UsersController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Product Management (resource path uses kebab-case but route names use snake_case to match views)
    Route::resource('san_pham', SanPhamController::class)->names([
        'index' => 'san_pham.index',
        'create' => 'san_pham.create',
        'store' => 'san_pham.store',
        'show' => 'san_pham.show',
        'edit' => 'san_pham.edit',
        'update' => 'san_pham.update',
        'destroy' => 'san_pham.destroy',
    ]);
    
    // Reviews Management
    Route::get('reviews', [DanhGiaController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{id}', [DanhGiaController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [DanhGiaController::class, 'destroy'])->name('reviews.destroy');
    Route::post('reviews/bulk-delete', [DanhGiaController::class, 'bulkDelete'])->name('reviews.bulk-delete');

    // Orders Management
    Route::get('don-hang', [DonHangController::class, 'index'])->name('don_hang.index');
    Route::get('don-hang/{id}', [DonHangController::class, 'show'])->name('don_hang.show');

    // Promotions Management
    Route::resource('khuyen-mai', KhuyenMaiController::class)->names([
        'index' => 'khuyen_mai.index',
        'create' => 'khuyen_mai.create',
        'store' => 'khuyen_mai.store',
        'show' => 'khuyen_mai.show',
        'edit' => 'khuyen_mai.edit',
        'update' => 'khuyen_mai.update',
        'destroy' => 'khuyen_mai.destroy',
    ]);

    // Reports / Statistics
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\DonHangController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\ReportController;

Route::get('/', function () {
    return view('welcome');
});



// Đặt các route admin vào một nhóm để dễ quản lý
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UsersController::class);
    Route::post('users/{id}/toggle-status', [UsersController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Product Management (resource path uses kebab-case but route names use snake_case to match views)
    Route::resource('san-pham', SanPhamController::class)->names([
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

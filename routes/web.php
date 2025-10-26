<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\FeedbackController;

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
    
    // Product Management
    Route::resource('san-pham', SanPhamController::class);
    
    // Reviews Management
    Route::get('reviews', [DanhGiaController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{id}', [DanhGiaController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [DanhGiaController::class, 'destroy'])->name('reviews.destroy');
    Route::post('reviews/bulk-delete', [DanhGiaController::class, 'bulkDelete'])->name('reviews.bulk-delete');
    
    // Feedback Management
    Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('feedback/{id}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::post('feedback/{id}/mark-processed', [FeedbackController::class, 'markAsProcessed'])->name('feedback.mark-processed');
    Route::post('feedback/{id}/mark-pending', [FeedbackController::class, 'markAsPending'])->name('feedback.mark-pending');
    Route::delete('feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
    Route::post('feedback/bulk-mark-processed', [FeedbackController::class, 'bulkMarkProcessed'])->name('feedback.bulk-mark-processed');
    Route::post('feedback/bulk-delete', [FeedbackController::class, 'bulkDelete'])->name('feedback.bulk-delete');
});

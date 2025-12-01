<?php

use Illuminate\Support\Facades\Route;

// Import Controllers
// --- Admin Controllers ---
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\DonHangController as AdminDonHangController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\FeedbackController; // Hoặc AdminFeedbackController nếu bạn đổi tên

// --- User/Front Controllers ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UsersController as UserUsersController;
use App\Http\Controllers\User\DonHangController as UserDonHangController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\ThanhToanController;

/*
|--------------------------------------------------------------------------
| NHÓM 1: PUBLIC ROUTES (Ai cũng có thể truy cập)
|--------------------------------------------------------------------------
*/

// Trang chủ & Tìm kiếm
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Sản phẩm & Danh mục
Route::get('/products/by-brand', [HomeController::class, 'productsByBrand'])->name('products.by-brand');
Route::get('/products/by-category/{categoryId}', [HomeController::class, 'productsByCategory'])->name('products.by-category');
Route::get('/products/{id}', [HomeController::class, 'show'])->name('products.show');

// Authentication (Đăng ký, Đăng nhập, Đăng xuất)
Route::get('/register', [UserUsersController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserUsersController::class, 'register']);
Route::get('/login', [UserUsersController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserUsersController::class, 'login']);
Route::post('/logout', [UserUsersController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| NHÓM 2: USER ROUTES (Bắt buộc Đăng nhập - Middleware 'auth')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // --- Giỏ hàng ---
    // Thêm vào giỏ (GET request từ thẻ a)
    Route::get('/add-to-cart/{id}', [UserDonHangController::class, 'addToCart'])->name('cart.add');
    
    // Xem và quản lý giỏ hàng
    Route::get('/cart', [UserDonHangController::class, 'viewCart'])->name('cart.index');
    Route::get('/cart/remove/{chiTietId}', [UserDonHangController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update/{chiTietId}', [UserDonHangController::class, 'updateCart'])->name('cart.update');

    // --- Thanh toán ---
    Route::post('/checkout/proceed', [ThanhToanController::class, 'proceedToPaymentPage'])->name('checkout.proceed');
    Route::get('/payment/{id}', [ThanhToanController::class, 'showPaymentPage'])->name('payment.show');
    Route::get('/payment/success/{id}', [ThanhToanController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel/{id}', [ThanhToanController::class, 'cancelPayment'])->name('payment.cancel');
    
    // Kiểm tra trạng thái thanh toán (Ajax Polling)
    Route::get('/payment/check/{id}', [ThanhToanController::class, 'checkPaymentStatus'])->name('payment.check_status');

    // --- Tài khoản & Đơn hàng ---
    Route::get('/orders', [UserDonHangController::class, 'index'])->name('user.orders.index');
    Route::get('/orders/{id}', [UserDonHangController::class, 'show'])->name('user.orders.show');
    
    Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('user.profile.update');

    // --- Gửi đánh giá sản phẩm ---
    Route::post('/products/{id}/review', [FeedbackController::class, 'postReview'])->name('products.review'); 
});


/*
|--------------------------------------------------------------------------
| NHÓM 3: ADMIN ROUTES (Bắt buộc Đăng nhập + Quyền Admin - Middleware 'admin')
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Quản lý Người dùng
    Route::resource('users', AdminUsersController::class);
    Route::post('users/{id}/toggle-status', [AdminUsersController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Quản lý Sản phẩm
    Route::resource('san_pham', SanPhamController::class)->names([
        'index' => 'san_pham.index',
        'create' => 'san_pham.create',
        'store' => 'san_pham.store',
        'show' => 'san_pham.show',
        'edit' => 'san_pham.edit',
        'update' => 'san_pham.update',
        'destroy' => 'san_pham.destroy',
    ]);

    // Quản lý Đánh giá
    Route::get('reviews', [DanhGiaController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{id}', [DanhGiaController::class, 'show'])->name('reviews.show');
    Route::delete('reviews/{id}', [DanhGiaController::class, 'destroy'])->name('reviews.destroy');
    Route::post('reviews/bulk-delete', [DanhGiaController::class, 'bulkDelete'])->name('reviews.bulk-delete');

    // Quản lý Đơn hàng
    Route::get('don-hang', [AdminDonHangController::class, 'index'])->name('don_hang.index');
    Route::get('don-hang/{id}', [AdminDonHangController::class, 'show'])->name('don_hang.show');
    Route::patch('don-hang/{id}', [AdminDonHangController::class, 'update'])->name('don_hang.update');

    // Quản lý Khuyến mãi
    Route::resource('khuyen-mai', KhuyenMaiController::class)->names([
        'index' => 'khuyen_mai.index',
        'create' => 'khuyen_mai.create',
        'store' => 'khuyen_mai.store',
        'show' => 'khuyen_mai.show',
        'edit' => 'khuyen_mai.edit',
        'update' => 'khuyen_mai.update',
        'destroy' => 'khuyen_mai.destroy',
    ]);

    // Báo cáo thống kê
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});
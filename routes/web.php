<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\User\UsersController as UserUsersController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Admin\ImagesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DanhGiaController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\DonHangController as AdminDonHangController;
;use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\DonHangController as UserDonHangController;
use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\User\ThanhToanController;

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/products/by-brand', [HomeController::class, 'productsByBrand'])->name('products.by-brand');
Route::get('/products/by-category/{categoryId}', [HomeController::class, 'productsByCategory'])->name('products.by-category');
Route::get('/products/{id}', [HomeController::class, 'show'])->name('products.show');


// --- Routes cho Đăng ký ---
Route::get('/register', [UserUsersController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserUsersController::class, 'register']);

// --- Routes cho Đăng nhập ---
Route::get('/login', [UserUsersController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserUsersController::class, 'login']);

// --- Route cho Đăng xuất ---
Route::post('/logout', [UserUsersController::class, 'logout'])->name('logout');
// --- Routes cho Đơn hàng của người dùng ---
Route::middleware('auth')->group(function () {
    Route::get('/orders', [UserDonHangController::class, 'index'])->name('user.orders.index');
    Route::get('/orders/{id}', [UserDonHangController::class, 'show'])->name('user.orders.show');
});

// // Đặt các route admin vào một nhóm để dễ quản lý
// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::resource('san_pham', SanPhamController::class);
// });


// Đặt các route admin vào một nhóm để dễ quản lý
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', AdminUsersController::class);
    Route::post('users/{id}/toggle-status', [AdminUsersController::class, 'toggleStatus'])->name('users.toggle-status');
    
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
    Route::get('don-hang', [AdminDonHangController::class, 'index'])->name('don_hang.index');
    Route::get('don-hang/{id}', [AdminDonHangController::class, 'show'])->name('don_hang.show');
    Route::patch('don-hang/{id}', [AdminDonHangController::class, 'update'])->name('don_hang.update');

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

Route::get('/add-to-cart/{id}', [UserDonHangController::class, 'addToCart'])->name('cart.add');

Route::middleware(['auth'])->group(function () {
    // Route thêm vào giỏ hàng (thường là POST hoặc GET)
    // Dùng POST an toàn hơn nếu bạn dùng form, GET nếu dùng link

    // Route xem giỏ hàng
    Route::get('/cart', [UserDonHangController::class, 'viewCart'])->name('cart.index');

    // Route xóa item khỏi giỏ
    Route::get('/cart/remove/{chiTietId}', [UserDonHangController::class, 'removeFromCart'])->name('cart.remove');

    // Route cập nhật số lượng (dùng POST)
    Route::post('/cart/update/{chiTietId}', [UserDonHangController::class, 'updateCart'])->name('cart.update');

    // --- KHU VỰC THANH TOÁN (ThanhToanController) ---

    // Bước 1: Xử lý nút "Đến trang thanh toán" từ Giỏ hàng
    Route::post('/checkout/proceed', [ThanhToanController::class, 'proceedToPaymentPage'])
        ->name('checkout.proceed');

    // Bước 2: Hiển thị trang có mã QR
    Route::get('/payment/{id}', [ThanhToanController::class, 'showPaymentPage'])
        ->name('payment.show');

    // Bước 3: Xử lý nút "Tôi đã thanh toán"
    Route::get('/payment/success/{id}', [ThanhToanController::class, 'paymentSuccess'])
        ->name('payment.success');

    // Route Hủy thanh toán (Trả hàng về kho)
    Route::get('/payment/cancel/{id}', [ThanhToanController::class, 'cancelPayment'])
        ->name('payment.cancel');
});

// --- Routes cho Thông tin người dùng (User Profile) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile/update', [UserProfileController::class, 'update'])->name('user.profile.update');
});
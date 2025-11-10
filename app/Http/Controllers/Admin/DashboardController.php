<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SanPham;
use App\Models\DanhGia;
use App\Models\DonHang;
use App\Models\KhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalUsers = User::count();
        $totalProducts = SanPham::count();
        $totalReviews = DanhGia::count();
        $totalOrders = DonHang::count();
        $totalPromotions = KhuyenMai::count();

        // Get recent data
        $userDateCol = Schema::hasColumn('users', 'created_at') ? 'created_at' : 'id';
        $recentUsers = User::with('role')
            ->orderByDesc($userDateCol)
            ->take(5)
            ->get();

        $danhGiaDateCol = Schema::hasColumn('danh_gia', 'created_at') ? 'created_at' : 'id';
        $recentReviews = DanhGia::with(['user', 'sanPham'])
            ->orderByDesc($danhGiaDateCol)
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalReviews',
            'recentUsers',
            'recentReviews',
            'totalOrders',
            'totalPromotions'
        ));
    }
}

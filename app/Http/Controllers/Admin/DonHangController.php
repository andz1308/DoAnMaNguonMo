<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $query = DonHang::with(['user', 'chiTietDonHang']);

        if ($request->has('search') && $request->search) {
            $s = $request->search;
            $query->whereHas('user', function($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%");
            });
        }

        $dateCol = Schema::hasColumn('don_hang', 'created_at') ? 'created_at' : 'id';
        $orders = $query->orderByDesc($dateCol)->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = DonHang::with(['user', 'chiTietDonHang', 'thanhToan'])->findOrFail($id);

        $html = '<div class="p-3">'
            . '<p><strong>Khách hàng:</strong> ' . ($order->user->name ?? 'N/A') . '</p>'
            . '<p><strong>Ghi chú:</strong> ' . ($order->ghi_chu ?? 'Không có') . '</p>'
            . '<p><strong>Tổng tiền:</strong> ' . number_format($order->thanhToan->tong_tien ?? 0) . ' VND</p>'
            . '</div>';

        return response($html);
    }
}

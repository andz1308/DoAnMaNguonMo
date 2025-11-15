<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $query = DonHang::with(['user', 'chiTietDonHang.sanPham', 'thanhToan']);

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('id', $term);

                $q->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });

                $q->orWhereHas('chiTietDonHang.sanPham', function ($productQuery) use ($term) {
                    $productQuery->where('name', 'like', "%{$term}%");
                });
            });
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('trang_thai', $request->status);
        }

        $hasPaymentDate = Schema::hasColumn('thanh_toan', 'ngay_thanh_toan');

        if ($hasPaymentDate) {
            $query->leftJoin('thanh_toan', 'thanh_toan.don_hang_id', '=', 'don_hang.id')
                ->select('don_hang.*', 'thanh_toan.ngay_thanh_toan as payment_date')
                ->orderByDesc('thanh_toan.ngay_thanh_toan')
                ->orderByDesc('don_hang.id');
        } else {
            $query->orderByDesc('id');
        }

        $orders = $query->paginate(15)->withQueryString();

        if ($hasPaymentDate) {
            $orders->load(['user', 'chiTietDonHang.sanPham', 'thanhToan']);
        }

        $statusOptions = DonHang::statusOptions();

        return view('admin.orders.index', compact('orders', 'statusOptions'));
    }

    public function show($id)
    {
        $order = DonHang::with([
            'user',
            'chiTietDonHang.sanPham.images',
            'thanhToan',
        ])->findOrFail($id);

        $statusOptions = DonHang::statusOptions();

        return view('admin.orders.show', compact('order', 'statusOptions'));
    }

    public function update(Request $request, $id)
    {
        $order = DonHang::findOrFail($id);

        $validated = $request->validate([
            'trang_thai' => ['required', Rule::in(array_keys(DonHang::statusOptions()))],
            'ghi_chu' => 'nullable|string',
        ]);

        $order->fill($validated);
        $order->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'status_label' => $order->trang_thai_label,
            ]);
        }

        return redirect()
            ->route('admin.don_hang.show', $order->id)
            ->with('success', 'Cập nhật đơn hàng thành công!');
    }
}

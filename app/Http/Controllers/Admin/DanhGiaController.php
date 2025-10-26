<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DanhGiaController extends Controller
{
    public function index(Request $request)
    {
        $query = DanhGia::with(['user', 'sanPham.images']);

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('sanPham', function($qs) use ($search) {
                    // DB column is `name` (migration uses `name`).
                    // Search against `name` to avoid unknown column errors.
                    $qs->where('name', 'like', "%{$search}%");
                })
                ->orWhere('noi_dung', 'like', "%{$search}%");
            });
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('so_sao', $request->rating);
        }

        // Filter by product
        if ($request->has('product') && $request->product) {
            $query->where('san_pham_id', $request->product);
        }

    $dateCol = Schema::hasColumn('danh_gia', 'created_at') ? 'created_at' : 'id';
    $reviews = $query->orderByDesc($dateCol)->paginate(15);

        // select the real column (`name`). We rely on the model accessor
        // so views/controllers can still read ->ten_san_pham.
        $products = SanPham::select('id', 'name')->get();

        // Statistics
        $totalReviews = DanhGia::count();
        $averageRating = DanhGia::avg('so_sao');
        $fiveStarReviews = DanhGia::where('so_sao', 5)->count();
        $lowRatingReviews = DanhGia::whereIn('so_sao', [1, 2])->count();

        return view('admin.reviews.index', compact(
            'reviews',
            'products',
            'totalReviews',
            'averageRating',
            'fiveStarReviews',
            'lowRatingReviews'
        ));
    }

    public function show($id)
    {
        $review = DanhGia::with(['user', 'sanPham.images'])->findOrFail($id);
        
        $html = '
        <div class="row">
            <div class="col-md-6">
                <h6>Thông tin người đánh giá</h6>
                <p><strong>Tên:</strong> ' . ($review->user->name ?? 'N/A') . '</p>
                <p><strong>Email:</strong> ' . ($review->user->email ?? 'N/A') . '</p>
            </div>
            <div class="col-md-6">
                <h6>Thông tin sản phẩm</h6>
                <p><strong>Sản phẩm:</strong> ' . ($review->sanPham->ten_san_pham ?? 'N/A') . '</p>
                <p><strong>Đánh giá:</strong> ' . ($review->so_sao ?? 0) . ' <i class="fas fa-star text-warning"></i></p>
            </div>
        </div>
        <div class="mt-3">
            <h6>Nội dung đánh giá</h6>
            <p>' . ($review->noi_dung ?? 'Không có nội dung') . '</p>
        </div>
        <div class="mt-3">
            <p class="text-muted"><small>Ngày đánh giá: ' . ($review->created_at ? $review->created_at->format('d/m/Y H:i') : 'N/A') . '</small></p>
        </div>
        ';

        return response($html);
    }

    public function destroy($id)
    {
        $review = DanhGia::findOrFail($id);
        $review->delete();

        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        DanhGia::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }
}

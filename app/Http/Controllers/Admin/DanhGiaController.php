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
            $query->where('vote', $request->rating);
        }

        // Filter by product
        if ($request->has('product') && $request->product) {
            $query->where('san_pham_id', $request->product);
        }

    $dateCol = Schema::hasColumn('danh_gia', 'created_at') ? 'created_at' : 'id';
    $reviews = $query->orderByDesc($dateCol)->paginate(15);

        // select the real column (`name`).
        $products = SanPham::select('id', 'name')->get();

        // Statistics
        $totalReviews = DanhGia::count();
        $averageRating = DanhGia::avg('vote');
        $fiveStarReviews = DanhGia::where('vote', 5)->count();
        $lowRatingReviews = DanhGia::whereIn('vote', [1, 2])->count();

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

        $imageName = $review->sanPham->images->first()->name
            ?? $review->sanPham->image
            ?? null;
        $imageTag = $imageName
            ? '<img src="' . asset('uploads/images/san_pham/' . $imageName) . '" alt="' . e($review->sanPham->name ?? '') . '" class="img-fluid rounded mb-3" style="max-width: 180px;">'
            : '';

        $html = '
        <div class="row">
            <div class="col-md-5 text-center">
                ' . $imageTag . '
            </div>
            <div class="col-md-7">
                <h6>Thông tin người đánh giá</h6>
                <p><strong>Tên:</strong> ' . ($review->user->name ?? 'N/A') . '</p>
                <p><strong>Email:</strong> ' . ($review->user->email ?? 'N/A') . '</p>
                <hr>
                <h6>Thông tin sản phẩm</h6>
                <p><strong>Sản phẩm:</strong> ' . ($review->sanPham->name ?? 'N/A') . '</p>
                <p><strong>Đánh giá:</strong> ' . ($review->vote ?? 0) . ' <i class="fas fa-star text-warning"></i></p>
            </div>
        </div>
        <div class="mt-3">
            <h6>Nội dung đánh giá</h6>
            <p>' . ($review->noi_dung ?? 'Không có nội dung') . '</p>
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

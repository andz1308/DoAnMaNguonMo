<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\SanPham; // Giả sử model sản phẩm là SanPham
use Illuminate\Support\Facades\Schema;

class DonHangController extends Controller
{
    /**
     * Quy ước:
     * trang_thai = 0 là "Giỏ hàng" (Đang chọn)
     * trang_thai = 1 là "Đã đặt hàng" (Chờ xử lý)
     * trang_thai = 2 là "Đã hoàn thành"
     * ...
     */

    /**
     * Thêm một sản phẩm vào giỏ hàng (Đơn hàng trạng thái 0)
     */
    public function addToCart(Request $request, $id)
    {
        // 1. KIỂM TRA ĐĂNG NHẬP THỦ CÔNG
        if (!Auth::check()) {
            // Lưu lại trang người dùng đang đứng (Trang chi tiết sản phẩm) làm đích đến sau khi login
            // url()->previous() chính là link trang sản phẩm họ vừa bấm nút
            session()->put('url.intended', url()->previous());

            // Chuyển hướng sang login
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để mua hàng.');
        }

        $sanPham = SanPham::find($id);
        if (!$sanPham) {
            return back()->with('error', 'Sản phẩm không tồn tại');
        }

        // ========== SỬA ĐỔI 1: LẤY SỐ LƯỢNG TỪ REQUEST ==========
        // Lấy số lượng từ input, nếu không có thì mặc định là 1
        $soLuongThem = $request->input('so_luong', 1);

        // Kiểm tra số lượng tồn kho
        // Dùng $soLuongThem thay vì 1
        if ($sanPham->so_luong_con < $soLuongThem) {
            return back()->with('error', 'Sản phẩm không đủ hàng');
        }

        $user = Auth::user();

        // ... (Phần firstOrCreate DonHang giữ nguyên) ...
        $donHang = DonHang::firstOrCreate(
            ['user_id' => $user->id, 'trang_thai' => 0],
            ['ghi_chu' => null]
        );

        $chiTiet = ChiTietDonHang::where('don_hang_id', $donHang->id)
            ->where('san_pham_id', $sanPham->id)
            ->first();

        if ($chiTiet) {
            // ========== SỬA ĐỔI 2: CỘNG THÊM SỐ LƯỢNG MỚI ==========
            $soLuongMoi = $chiTiet->so_luong + $soLuongThem; // Cộng số lượng mới vào

            // Kiểm tra lại tồn kho với tổng số lượng mới
            if ($sanPham->so_luong_con < $soLuongMoi) {
                return back()->with('error', 'Số lượng trong giỏ vượt quá tồn kho!');
            }

            $chiTiet->so_luong = $soLuongMoi; // Gán lại
            $chiTiet->save();

        } else {
            // ========== SỬA ĐỔI 3: TẠO MỚI VỚI SỐ LƯỢNG MỚI ==========
            ChiTietDonHang::create([
                'don_hang_id' => $donHang->id,
                'san_pham_id' => $sanPham->id,
                'so_luong' => $soLuongThem // Dùng $soLuongThem thay vì 1
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }

    /**
     * Hiển thị trang giỏ hàng
     */
    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Lấy giỏ hàng (đơn hàng trạng thái 0) của user
        // Kèm theo thông tin chi tiết (chiTietDonHang) và thông tin sản phẩm (sanPham)
        $cart = DonHang::with('chiTietDonHang.sanPham')
            ->where('user_id', Auth::id())
            ->where('trang_thai', 0)
            ->first();

        // Bạn cần tạo view 'home.cart' (dựa theo cấu trúc thư mục của bạn)
        return view('home.cart', compact('cart'));
    }

    /**
     * Xóa một item khỏi giỏ hàng
     */
    public function removeFromCart($chiTietId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $chiTiet = ChiTietDonHang::find($chiTietId);

        // Kiểm tra xem chi tiết này có thuộc đơn hàng (trạng thái 0) của user đang đăng nhập không
        if ($chiTiet && $chiTiet->donHang->user_id == Auth::id() && $chiTiet->donHang->trang_thai == 0) {
            $chiTiet->delete();
            return back()->with('success', 'Đã xóa sản phẩm');
        }

        return back()->with('error', 'Không tìm thấy sản phẩm');
    }

    /**
     * Cập nhật số lượng
     */
    public function updateCart(Request $request, $chiTietId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $chiTiet = ChiTietDonHang::find($chiTietId);
        $so_luong_moi = $request->input('so_luong');

        if ($so_luong_moi < 1) {
            return $this->removeFromCart($chiTietId);
        }

        if ($chiTiet && $chiTiet->donHang->user_id == Auth::id() && $chiTiet->donHang->trang_thai == 0) {
            // (Nên kiểm tra số lượng tồn kho ở đây)
            $chiTiet->so_luong = $so_luong_moi;
            $chiTiet->save();
            return back()->with('success', 'Cập nhật số lượng thành công');
        }
        return back()->with('error', 'Không thể cập nhật');
    }

    //-------------------------------------------
    //Quản lí đơn hàng của user

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = DonHang::with(['chiTietDonHang.sanPham.images', 'thanhToan'])
            ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('id', $term)
                    ->orWhereHas('chiTietDonHang.sanPham', function ($productQuery) use ($term) {
                        $productQuery->where('id', $term)
                            ->orWhere('name', 'like', "%{$term}%");
                    });
            });
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('trang_thai', $request->status);
        }

        $hasPaymentDate = Schema::hasColumn('thanh_toan', 'ngay_thanh_toan');

        if ($hasPaymentDate && $request->filled('from_date')) {
            $query->whereHas('thanhToan', function ($payQuery) use ($request) {
                $payQuery->whereDate('ngay_thanh_toan', '>=', $request->from_date);
            });
        }

        if ($hasPaymentDate && $request->filled('to_date')) {
            $query->whereHas('thanhToan', function ($payQuery) use ($request) {
                $payQuery->whereDate('ngay_thanh_toan', '<=', $request->to_date);
            });
        }

        if ($hasPaymentDate) {
            $query->leftJoin('thanh_toan', 'thanh_toan.don_hang_id', '=', 'don_hang.id')
                ->select('don_hang.*', 'thanh_toan.ngay_thanh_toan as payment_date')
                ->orderByDesc('thanh_toan.ngay_thanh_toan')
                ->orderByDesc('don_hang.id');
        } else {
            $hasCreatedAt = Schema::hasColumn('don_hang', 'created_at');
            $query->orderByDesc($hasCreatedAt ? 'created_at' : 'id');
        }

        $orders = $query->paginate(10)->withQueryString();

        if ($hasPaymentDate) {
            $orders->load(['chiTietDonHang.sanPham.images', 'thanhToan']);
        }

        $statusOptions = DonHang::statusOptions();

        return view('home.orders.index', compact('orders', 'statusOptions'));
    }

    public function show($id)
    {
        $userId = Auth::id();

        $order = DonHang::with(['chiTietDonHang.sanPham.images', 'thanhToan'])
            ->where('user_id', $userId)
            ->findOrFail($id);

        $statusOptions = DonHang::statusOptions();

        return view('home.orders.show', compact('order', 'statusOptions'));
    }

}
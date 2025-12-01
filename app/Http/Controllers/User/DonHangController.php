<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\SanPham; 
use Illuminate\Support\Facades\Schema;

class DonHangController extends Controller
{

    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            session()->put('url.intended', url()->previous());

            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để mua hàng.');
        }

        $sanPham = SanPham::find($id);
        if (!$sanPham) {
            return back()->with('error', 'Sản phẩm không tồn tại');
        }

        $soLuongThem = $request->input('so_luong', 1);

        if ($sanPham->so_luong_con < $soLuongThem) {
            return back()->with('error', 'Sản phẩm không đủ hàng');
        }

        $user = Auth::user();

        $donHang = DonHang::firstOrCreate(
            ['user_id' => $user->id, 'trang_thai' => DonHang::STATUS_CART],
            ['ghi_chu' => null]
        );

        $chiTiet = ChiTietDonHang::where('don_hang_id', $donHang->id)
            ->where('san_pham_id', $sanPham->id)
            ->first();

        if ($chiTiet) {
            $soLuongMoi = $chiTiet->so_luong + $soLuongThem; 

            if ($sanPham->so_luong_con < $soLuongMoi) {
                return back()->with('error', 'Số lượng trong giỏ vượt quá tồn kho!');
            }

            $chiTiet->so_luong = $soLuongMoi;
            $chiTiet->save();

        } else {
            ChiTietDonHang::create([
                'don_hang_id' => $donHang->id,
                'san_pham_id' => $sanPham->id,
                'so_luong' => $soLuongThem 
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
    }


    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = DonHang::with('chiTietDonHang.sanPham')
            ->where('user_id', Auth::id())
            ->where('trang_thai', DonHang::STATUS_CART)
            ->first();

        return view('home.cart', compact('cart'));
    }

    public function removeFromCart($chiTietId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $chiTiet = ChiTietDonHang::find($chiTietId);

        if ($chiTiet && $chiTiet->donHang->user_id == Auth::id() && $chiTiet->donHang->trang_thai == DonHang::STATUS_CART) {
            $chiTiet->delete();
            return back()->with('success', 'Đã xóa sản phẩm');
        }

        return back()->with('error', 'Không tìm thấy sản phẩm');
    }
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

        if ($chiTiet && $chiTiet->donHang->user_id == Auth::id() && $chiTiet->donHang->trang_thai == DonHang::STATUS_CART) {
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
        unset($statusOptions[4]);

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
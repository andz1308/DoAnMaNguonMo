<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DonHang;
use App\Models\ThanhToan;
use App\Models\SanPham; // Nhớ use Model này

class ThanhToanController extends Controller
{
    /**
     * BƯỚC 1: GIỮ CHỖ (Trừ kho ngay & Chuyển trạng thái sang 1)
     */
    public function proceedToPaymentPage(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        DB::beginTransaction();
        try {
            // 1. Tìm giỏ hàng (trạng thái 0)
            $cart = DonHang::with('chiTietDonHang.sanPham')
                        ->where('user_id', Auth::id())
                        ->where('trang_thai', 0)
                        ->lockForUpdate() // Khóa dòng này để xử lý
                        ->first();

            if (!$cart || $cart->chiTietDonHang->isEmpty()) {
                return back()->with('error', 'Giỏ hàng trống!');
            }

            // 2. Kiểm tra kho và TRỪ KHO NGAY LẬP TỨC
            foreach ($cart->chiTietDonHang as $item) {
                $sanPham = $item->sanPham;
                
                // Kiểm tra đủ hàng không
                if ($sanPham->so_luong_con < $item->so_luong) {
                    throw new \Exception('Sản phẩm "' . $sanPham->name . '" không đủ hàng (chỉ còn ' . $sanPham->so_luong_con . ').');
                }

                // Trừ kho luôn (Giữ hàng)
                $sanPham->decrement('so_luong_con', $item->so_luong);
            }

            // 3. Cập nhật trạng thái -> 1 (Chờ thanh toán)
            $cart->ghi_chu = $request->input('ghi_chu');
            $cart->trang_thai = 1; 
            $cart->save();

            DB::commit();
            
            // Chuyển đến trang QR
            return redirect()->route('payment.show', ['id' => $cart->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * BƯỚC 2: Hiển thị trang QR (Lấy đơn hàng trạng thái 1)
     */
    public function showPaymentPage($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        // Tìm đơn hàng đang chờ thanh toán (Trạng thái 1)
        $donHang = DonHang::with('chiTietDonHang.sanPham')
                        ->where('id', $id)
                        ->where('user_id', Auth::id())
                        ->where('trang_thai', 1) // Đang giữ chỗ
                        ->firstOrFail();

        // Tính tiền
        $totalMoney = 0;
        foreach ($donHang->chiTietDonHang as $item) {
            $totalMoney += $item->sanPham->gia * $item->so_luong;
        }

        // --- SỬA LẠI HOÀN TOÀN CÁCH TẠO QR ---

        // 1. Mã ngân hàng của VietinBank (dùng cho link img.vietqr.io)
        $bankCode = "970415"; // (Vietcombank là VCB, VietinBank là CTG)

        // 2. Số tài khoản của bạn
        $accountNo = "101877194831";

        // 3. Mẫu template (giống của bạn bạn)
        $template = "compact2";

        // 4. Nội dung (cần mã hóa)
        $memo = "DH" . $donHang->id;
        $encodedMemo = urlencode($memo); // Mã hóa để link không bị lỗi

        // 5. Tạo link mới (Không cần accountName)
        $qrApiUrl = "https://img.vietqr.io/image/{$bankCode}-{$accountNo}-{$template}.png?amount={$totalMoney}&addInfo={$encodedMemo}";

        return view('home.payment', compact('donHang', 'totalMoney', 'qrApiUrl', 'memo'));
    }

    /**
     * BƯỚC 3: XÁC NHẬN THANH TOÁN (Chỉ cần ghi nhận tiền)
     */
    public function paymentSuccess($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        // Tìm đơn hàng đang chờ (1)
        $donHang = DonHang::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->where('trang_thai', 1)
                        ->first();
        
        if (!$donHang) {
            return redirect()->route('home')->with('error', 'Đơn hàng không hợp lệ.');
        }

        // Tính lại tổng tiền để lưu
        // (Lúc này không cần lo hết hàng nữa vì đã trừ ở Bước 1 rồi)
        $totalMoney = 0;
        foreach ($donHang->chiTietDonHang as $item) {
            $totalMoney += $item->sanPham->gia * $item->so_luong;
        }

        // Tạo bản ghi thanh toán
        ThanhToan::updateOrCreate(
            ['don_hang_id' => $donHang->id],
            [
                'ngay_thanh_toan' => now(),
                'tong_tien' => $totalMoney
            ]
        );

        // Chuyển trạng thái -> 2 (Hoàn thành/Đã trả tiền)
        $donHang->trang_thai = 2; 
        $donHang->save();

        return redirect()->route('home')->with('message', 'Thanh toán thành công!');
    }

    /**
     * BƯỚC 4 (MỚI): HỦY THANH TOÁN (Trả hàng lại kho)
     * Dùng khi khách đổi ý tại trang QR
     */
    public function cancelPayment($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        DB::beginTransaction();
        try {
            $donHang = DonHang::with('chiTietDonHang.sanPham')
                            ->where('id', $id)
                            ->where('user_id', Auth::id())
                            ->where('trang_thai', 1) // Chỉ hủy đơn đang chờ
                            ->firstOrFail();

            // Hoàn trả số lượng kho
            foreach ($donHang->chiTietDonHang as $item) {
                $item->sanPham->increment('so_luong_con', $item->so_luong);
            }

            // Quay về trạng thái 0 (Giỏ hàng) để khách mua tiếp hoặc sửa
            // Hoặc xóa luôn đơn hàng tùy bạn (ở đây tôi chọn quay về giỏ)
            $donHang->trang_thai = 0;
            $donHang->save();

            DB::commit();
            return redirect()->route('cart.index')->with('error', 'Đã hủy thanh toán, hàng đã được trả lại vào kho.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back();
        }
    }
}
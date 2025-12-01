<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DonHang;
use App\Models\ThanhToan;
use App\Models\SanPham; 

class ThanhToanController extends Controller
{

    public function proceedToPaymentPage(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        DB::beginTransaction();
        try {
            $cart = DonHang::with('chiTietDonHang.sanPham')
                        ->where('user_id', Auth::id())
                        ->where('trang_thai', DonHang::STATUS_CART)
                        ->lockForUpdate() 
                        ->first();

            if (!$cart || $cart->chiTietDonHang->isEmpty()) {
                return back()->with('error', 'Giỏ hàng trống!');
            }

            foreach ($cart->chiTietDonHang as $item) {
                $sanPham = $item->sanPham;
                
                if ($sanPham->so_luong_con < $item->so_luong) {
                    throw new \Exception('Sản phẩm "' . $sanPham->name . '" không đủ hàng (chỉ còn ' . $sanPham->so_luong_con . ').');
                }

                $sanPham->decrement('so_luong_con', $item->so_luong);
            }

            $cart->ghi_chu = $request->input('ghi_chu');
            $paymentMethod = $request->input('payment_method');

            if ($paymentMethod == 'cod') {
                $cart->trang_thai = DonHang::STATUS_PROCESSING; 
                $cart->save();

                $totalMoney = 0;
                foreach ($cart->chiTietDonHang as $item) {
                     $totalMoney += $item->sanPham->gia_ban * $item->so_luong;
                }
                ThanhToan::create([
                    'don_hang_id' => $cart->id,
                    'tong_tien' => $totalMoney,
                    'ngay_thanh_toan' => now(),
                    'phuong_thuc' => 'cod'
                ]);

                DB::commit();
                return redirect()->route('home')->with('message', 'Đặt hàng thành công (COD)! Chúng tôi sẽ sớm liên hệ.');
            
            }else {
                $cart->trang_thai = DonHang::STATUS_PENDING; 
                $cart->save();
                
                DB::commit();
                return redirect()->route('payment.show', ['id' => $cart->id]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function showPaymentPage($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        $donHang = DonHang::with('chiTietDonHang.sanPham')
                        ->where('id', $id)
                        ->where('user_id', Auth::id())
                        ->where('trang_thai', DonHang::STATUS_PENDING)
                        ->firstOrFail();

        $totalMoney = 0;
        foreach ($donHang->chiTietDonHang as $item) {
            $totalMoney += $item->sanPham->gia_ban * $item->so_luong;
        }

        $bankCode = "970415"; 

        $accountNo = "101877194831";

        $template = "compact2";

        $memo = "DH" . $donHang->id;
        $encodedMemo = urlencode($memo); 

        $qrApiUrl = "https://img.vietqr.io/image/{$bankCode}-{$accountNo}-{$template}.png?amount={$totalMoney}&addInfo={$encodedMemo}";

        return view('home.payment', compact('donHang', 'totalMoney', 'qrApiUrl', 'memo'));
    }

    public function paymentSuccess($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        $donHang = DonHang::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->where('trang_thai', DonHang::STATUS_PENDING)
                        ->first();
        
        if (!$donHang) {
            return redirect()->route('home')->with('error', 'Đơn hàng không hợp lệ.');
        }

        $totalMoney = 0;
        foreach ($donHang->chiTietDonHang as $item) {
            $totalMoney += $item->sanPham->gia_ban * $item->so_luong;
        }

        ThanhToan::updateOrCreate(
            ['don_hang_id' => $donHang->id],
            [
                'ngay_thanh_toan' => now(),
                'tong_tien' => $totalMoney,
                'phuong_thuc' => 'qr'
            ]
        );

        $donHang->trang_thai = DonHang::STATUS_PROCESSING; 
        $donHang->save();

        return redirect()->route('home')->with('message', 'Thanh toán thành công!');
    }

    public function cancelPayment($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        DB::beginTransaction();
        try {
            $donHang = DonHang::with('chiTietDonHang.sanPham')
                            ->where('id', $id)
                            ->where('user_id', Auth::id())
                            ->where('trang_thai', DonHang::STATUS_PENDING) 
                            ->firstOrFail();

            foreach ($donHang->chiTietDonHang as $item) {
                $item->sanPham->increment('so_luong_con', $item->so_luong);
            }

            $donHang->trang_thai = DonHang::STATUS_CART;
            $donHang->save();

            DB::commit();
            return redirect()->route('cart.index')->with('error', 'Đã hủy thanh toán, hàng đã được trả lại vào kho.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back();
        }
    }
}
@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="span9" style="font-family: 'Roboto', Arial, sans-serif !important;">
    
    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 25px; border: 1px solid #f0f0f0;">
        <div style="border-left: 5px solid #ee4d2d; padding-left: 15px; margin-bottom: 25px;">
            <h3 style="margin: 0; color: #333; font-weight: 700; font-size: 24px; text-transform: uppercase; line-height: 1;">
                Đơn hàng của tôi
            </h3>
            <p style="margin: 5px 0 0; color: #888; font-size: 13px;">Quản lý và theo dõi vận chuyển</p>
        </div>

        <form method="GET" action="{{ route('user.orders.index') }}" style="margin: 0; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div style="flex: 2; min-width: 280px; position: relative;">
                <i class="icon-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999; font-size: 16px; z-index: 2;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo Mã đơn / Tên sản phẩm..." 
                       style="width: 100%; height: 45px !important; line-height: 45px; padding: 0 15px 0 45px !important; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 14px; box-sizing: border-box; outline: none; background: #fafafa; margin-bottom: 0 !important;">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <select name="status" style="width: 100%; height: 45px !important; line-height: 45px; border: 1px solid #e0e0e0; border-radius: 4px; padding: 0 10px; background-color: #fafafa; color: #555; outline: none; cursor: pointer; box-sizing: border-box; margin-bottom: 0 !important;">
                    <option value="">-- Tất cả trạng thái --</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ (string)request('status') === (string)$value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn" style="background: #ee4d2d; color: #fff; border: none; height: 45px; padding: 0 30px; border-radius: 4px; font-weight: 600; font-size: 14px; cursor: pointer; text-shadow: none; box-sizing: border-box; line-height: 1;">Lọc</button>
                <a href="{{ route('user.orders.index') }}" class="btn" style="background: #fff; border: 1px solid #ddd; height: 45px; padding: 0 20px; border-radius: 4px; color: #555; font-weight: 500; cursor: pointer; text-shadow: none; box-sizing: border-box; display: flex; align-items: center;">Đặt lại</a>
            </div>
        </form>
    </div>

    <div>
        @forelse($orders as $order)
            @php
                // --- LOGIC XÁC ĐỊNH TRẠNG THÁI (Dùng chung cho cả Màu và Nút) ---
                $isProcessing = ($order->trang_thai == 1 || $order->trang_thai == \App\Models\DonHang::STATUS_PROCESSING);
                
                // Kiểm tra linh hoạt: ID là 2 HOẶC tên có chữ 'thanh toán' HOẶC id = 0 (Giỏ hàng/Mới tạo)
                $isPaying = ($order->trang_thai == 2 || stripos($order->trang_thai_label, 'thanh toán') !== false || $order->trang_thai == 0);
                
                $isCompleted = ($order->trang_thai == \App\Models\DonHang::STATUS_COMPLETED);
                $isCancelled = ($order->trang_thai == \App\Models\DonHang::STATUS_CANCELLED);

                // --- MÀU SẮC ---
                $statusColor = '#333'; $statusBg = '#f0f0f0'; $statusIcon = 'icon-tag';
                
                if ($isProcessing) { // Đang xử lý (Đã thanh toán -> Shop đang gói)
                    $statusColor = '#007bff'; $statusBg = '#e7f1ff'; $statusIcon = 'icon-refresh';
                } 
                elseif ($isPaying) { // Đang thanh toán (Chưa xong -> Được Hủy)
                    $statusColor = '#ff9800'; $statusBg = '#fff3e0'; $statusIcon = 'icon-briefcase';
                } 
                elseif ($isCompleted) { 
                    $statusColor = '#28a745'; $statusBg = '#e6f9ea'; $statusIcon = 'icon-ok';
                } 
                elseif ($isCancelled) { 
                    $statusColor = '#dc3545'; $statusBg = '#fce8e6'; $statusIcon = 'icon-remove';
                }
            @endphp

            <div style="background: #fff; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #eee; overflow: hidden;">
                
                <div style="padding: 15px 20px; border-bottom: 1px solid #f5f5f5; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                    <div style="display: flex; align-items: center;">
                        <span style="background: #ee4d2d; color: white; padding: 3px 6px; font-size: 11px; border-radius: 3px; margin-right: 10px; font-weight: bold; letter-spacing: 0.5px;">MALL</span>
                        <strong style="color: #333; font-size: 15px;">#{{ $order->id }}</strong>
                        <span style="color: #ddd; margin: 0 12px;">|</span>
                        <span style="color: #888; font-size: 13px;">{{ $order->created_at->format('H:i d/m/Y') }}</span>
                    </div>
                    <div style="background: {{ $statusBg }}; color: {{ $statusColor }}; padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; display: flex; align-items: center;">
                        <i class="{{ $statusIcon }}" style="margin-right: 6px; opacity: 0.8;"></i> {{ $order->trang_thai_label }}
                    </div>
                </div>

                <div style="padding: 0 20px;">
                    @foreach($order->chiTietDonHang as $chiTiet)
                        @php 
                            $sanPham = $chiTiet->sanPham;
                            $imgName = optional($sanPham->images->first())->name;
                            $imgUrl = $imgName ? asset('uploads/images/san_pham/' . $imgName) : 'https://placehold.co/80x80/f5f5f5/999?text=NoImg';
                        @endphp
                        <div style="display: flex; align-items: center; padding: 20px 0; border-bottom: 1px solid #f9f9f9;">
                            <div style="width: 82px; height: 82px; border: 1px solid #f0f0f0; border-radius: 4px; margin-right: 15px; flex-shrink: 0; overflow: hidden; background: #fff;">
                                <img src="{{ $imgUrl }}" alt="{{ $sanPham->name }}" 
                                     style="width: 80px !important; height: 80px !important; object-fit: contain; display: block;"
                                     onerror="this.src='https://placehold.co/80x80?text=Err'">
                            </div>
                            <div style="flex: 1;">
                                <h5 style="margin: 0 0 6px; font-size: 15px; font-weight: 500; line-height: 1.4;">
                                    <a href="#" style="color: #333; text-decoration: none;">{{ $sanPham->name }}</a>
                                </h5>
                                <div style="color: #888; font-size: 13px; margin-bottom: 6px;">Phân loại: {{ $sanPham->dung_luong ?? 'Tiêu chuẩn' }}</div>
                                <div style="font-size: 14px; color: #333;">x{{ $chiTiet->so_luong }}</div>
                            </div>
<div style="text-align: right; min-width: 120px;">
    @if($sanPham->gia > $sanPham->gia_ban)
        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
            <span style="text-decoration: line-through; font-size: 14px; color: #999;">
                {{ number_format($sanPham->gia, 0, ',', '.') }}₫
            </span>
            <span style="color: #ee4d2d; font-weight: 600; font-size: 16px;">
                {{ number_format($sanPham->gia_ban, 0, ',', '.') }}₫
            </span>
        </div>
    @else
        <span style="color: #ee4d2d; font-weight: 600; font-size: 16px;">
            {{ number_format($sanPham->gia, 0, ',', '.') }}₫
        </span>
    @endif
</div>
                        </div>
                    @endforeach
                </div>

                <div style="background: #fffaf0; padding: 15px 20px; border-top: 1px solid #f5f5f5; display: flex; flex-direction: column; align-items: flex-end;">
                    <div style="margin-bottom: 15px; display: flex; align-items: baseline;">
                        <span style="font-size: 14px; color: #555; margin-right: 10px;">Thành tiền:</span>
                        <span style="font-size: 24px; color: #ee4d2d; font-weight: 700;">{{ number_format($order->tong_tien, 0, ',', '.') }}₫</span>
                    </div>
                    
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('user.orders.show', $order->id) }}" class="btn" style="background: #fff; border: 1px solid #ddd; color: #555; padding: 0 20px; height: 40px; line-height: 38px; border-radius: 4px; font-weight: 500; box-shadow: 0 1px 1px rgba(0,0,0,0.05);">
                            Xem chi tiết
                        </a>

                        @if($isPaying) 
                            {{-- TH1: ĐANG THANH TOÁN -> Hiện nút Thanh toán & Hủy --}}
                            
                            {{-- NÚT THANH TOÁN MỚI THÊM --}}
                            <a href="{{ route('payment.show', $order->id) }}" class="btn" style="background: #ee4d2d; border: 1px solid #ee4d2d; color: #fff; padding: 0 20px; height: 40px; line-height: 38px; border-radius: 4px; font-weight: 500;">
                                Thanh toán ngay
                            </a>

                            <a href="{{ route('payment.cancel', $order->id) }}" class="btn" style="background: #fff; border: 1px solid #dc3545; color: #dc3545; padding: 0 20px; height: 40px; line-height: 38px; border-radius: 4px; font-weight: 500;">
                                Hủy đơn hàng
                            </a>

                        @elseif($isProcessing)
                            {{-- TH2: ĐANG XỬ LÝ -> Chỉ được Liên hệ Shop --}}
                            <button class="btn" style="background: #fff; border: 1px solid #ccc; color: #333; padding: 0 20px; height: 40px; line-height: 38px; border-radius: 4px;">
                                Liên hệ Shop
                            </button>

                        @elseif($isCompleted || $isCancelled)
                            {{-- TH3: ĐÃ XONG / ĐÃ HỦY -> Mua lại --}}
                            <button class="btn" style="background: #ee4d2d; border: 1px solid #ee4d2d; color: #fff; padding: 0 25px; height: 40px; border-radius: 4px; font-weight: 500; text-shadow: none;">
                                Mua lại
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <div style="background: #fff; padding: 60px 20px; text-align: center; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/orderlist/5fafbb923393b712b96488590b8f781d.png" alt="Empty" style="width: 120px; margin-bottom: 20px; opacity: 0.8;">
                <h4 style="color: #555; font-weight: 400; margin-bottom: 20px;">Chưa có đơn hàng nào</h4>
                <a href="{{ route('home') }}" class="btn" style="background: #ee4d2d; color: #fff; border: none; padding: 12px 40px; border-radius: 4px; font-weight: 600; font-size: 16px; text-shadow: none;">Mua sắm ngay</a>
            </div>
        @endforelse
    </div>

    <div class="pagination pagination-centered">
        {{ $orders->links() }}
    </div>
</div>
@endsection
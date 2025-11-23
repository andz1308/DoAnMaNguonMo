@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="span9" style="font-family: 'Roboto', Arial, sans-serif !important; color: #333;">

    <div style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">

        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 25px;">
            <div>
                <h3 style="margin: 0; font-size: 22px; color: #333; font-weight: 700; text-transform: uppercase;">
                    Chi tiết đơn hàng #{{ $order->id }}
                </h3>
                <p style="margin: 5px 0 0; color: #888; font-size: 13px;">
                    Ngày đặt: {{ $order->created_at->format('H:i d/m/Y') }}
                </p>
            </div>
            <a href="{{ route('user.orders.index') }}" class="btn" style="background: #fff; border: 1px solid #ddd; padding: 8px 15px; border-radius: 4px; color: #555; font-weight: 500; text-decoration: none; display: flex; align-items: center; gap: 5px;">
                <i class="icon-arrow-left"></i> Quay lại danh sách
            </a>
        </div>

        @php
            // Logic màu sắc (Copy từ trang index)
            $statusColor = '#333'; $statusBg = '#f0f0f0'; $statusIcon = 'icon-tag';
            
            if ($order->trang_thai == 1) { // Đang xử lý
                $statusColor = '#007bff'; $statusBg = '#e7f1ff'; $statusIcon = 'icon-refresh';
            } elseif ($order->trang_thai == 2 || stripos($order->trang_thai_label, 'thanh toán') !== false) { // Thanh toán
                $statusColor = '#ff9800'; $statusBg = '#fff3e0'; $statusIcon = 'icon-briefcase';
            } elseif ($order->trang_thai == \App\Models\DonHang::STATUS_COMPLETED) { // Hoàn thành
                $statusColor = '#28a745'; $statusBg = '#e6f9ea'; $statusIcon = 'icon-ok';
            } elseif ($order->trang_thai == \App\Models\DonHang::STATUS_CANCELLED) { // Hủy
                $statusColor = '#dc3545'; $statusBg = '#fce8e6'; $statusIcon = 'icon-remove';
            }
        @endphp

        <div style="display: flex; gap: 30px; margin-bottom: 30px; flex-wrap: wrap;">
            <div style="flex: 1; background: #fafafa; padding: 20px; border-radius: 6px; border: 1px solid #eee;">
                <h4 style="margin: 0 0 15px 0; font-size: 16px; font-weight: 700; color: #555; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    THÔNG TIN ĐƠN HÀNG
                </h4>
                <div style="margin-bottom: 10px;">
                    <span style="color: #888; font-size: 14px;">Trạng thái:</span>
                    <span style="background: {{ $statusBg }}; color: {{ $statusColor }}; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-left: 5px; display: inline-block;">
                        <i class="{{ $statusIcon }}"></i> {{ $order->trang_thai_label }}
                    </span>
                </div>
                <div>
                    <span style="color: #888; font-size: 14px;">Ghi chú:</span>
                    <span style="color: #333; font-style: italic;">{{ $order->ghi_chu ?? 'Không có ghi chú' }}</span>
                </div>
            </div>

            <div style="flex: 1; background: #fafafa; padding: 20px; border-radius: 6px; border: 1px solid #eee;">
                <h4 style="margin: 0 0 15px 0; font-size: 16px; font-weight: 700; color: #555; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                    THÔNG TIN THANH TOÁN
                </h4>
                <div style="margin-bottom: 10px;">
                    <span style="color: #888; font-size: 14px;">Phương thức:</span>
                    <span style="color: #333; font-weight: 500;">Chuyển khoản / QR Code</span>
                </div>
                <div>
                    <span style="color: #888; font-size: 14px;">Thời gian thanh toán:</span>
                    @if(optional($order->thanhToan)->ngay_thanh_toan)
                        <span style="color: #28a745; font-weight: 500;">
                            <i class="icon-ok-circle"></i> {{ \Carbon\Carbon::parse($order->thanhToan->ngay_thanh_toan)->format('H:i d/m/Y') }}
                        </span>
                    @else
                        <span style="color: #dc3545; font-weight: 500;">Chưa thanh toán</span>
                    @endif
                </div>
            </div>
        </div>

        <h4 style="margin-bottom: 15px; font-size: 18px; color: #333; font-weight: 600;">Sản phẩm đã mua</h4>

<div style="border: 1px solid #eee; border-radius: 6px; overflow: hidden;">
    <div style="display: flex; background: #f8f8f8; padding: 12px 15px; font-weight: 600; font-size: 14px; color: #555; border-bottom: 1px solid #eee;">
        <div style="flex: 4;">Sản phẩm</div>
        <div style="flex: 1; text-align: center;">Số lượng</div>
        <div style="flex: 1.5; text-align: right;">Đơn giá</div>
        <div style="flex: 1.5; text-align: right;">Thành tiền</div>
    </div>

    @foreach($order->chiTietDonHang as $item)
        @php 
            $sanPham = $item->sanPham;
            
            // Lấy giá bán thực tế (đã trừ khuyến mãi nếu có)
            $giaThucTe = $sanPham->gia_ban ?? $sanPham->gia;

            // Logic lấy ảnh
            $imgName = optional($sanPham->images->first())->name ?? $sanPham->image;
            $imgUrl = $imgName ? asset('uploads/images/san_pham/' . $imgName) : 'https://placehold.co/60x60/eee/999?text=NoImg';
        @endphp

        <div style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #f5f5f5; background: #fff;">
            <!-- Cột Sản phẩm -->
            <div style="flex: 4; display: flex; align-items: center;">
                <div style="width: 62px; height: 62px; border: 1px solid #eee; border-radius: 4px; margin-right: 15px; flex-shrink: 0; overflow: hidden;">
                    <img src="{{ $imgUrl }}" alt="{{ $sanPham->name ?? '' }}" 
                         style="width: 60px !important; height: 60px !important; object-fit: cover; display: block;"
                         onerror="this.src='https://placehold.co/60x60?text=Err'">
                </div>
                <div>
                    <div style="font-weight: 500; color: #333; margin-bottom: 4px;">
                        {{ $sanPham->name ?? 'Sản phẩm đã bị xóa' }}
                    </div>
                    <div style="font-size: 12px; color: #999;">
                        Phân loại: {{ $sanPham->dung_luong ?? 'Tiêu chuẩn' }}
                        
                        <!-- Hiển thị nhãn giảm giá nhỏ nếu có -->
                        @if($sanPham->gia > $giaThucTe)
                            <span style="background: #ffebee; color: #c62828; padding: 2px 6px; border-radius: 3px; font-size: 10px; margin-left: 5px; font-weight: bold;">
                                Giảm giá
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cột Số lượng -->
            <div style="flex: 1; text-align: center; color: #555;">
                x{{ $item->so_luong }}
            </div>

            <!-- Cột Đơn giá -->
            <div style="flex: 1.5; text-align: right;">
                @if($sanPham->gia > $giaThucTe)
                    <!-- Giá gốc gạch ngang -->
                    <div style="text-decoration: line-through; color: #999; font-size: 12px;">
                        {{ number_format($sanPham->gia, 0, ',', '.') }}₫
                    </div>
                    <!-- Giá khuyến mãi -->
                    <div style="color: #d32f2f; font-weight: 600;">
                        {{ number_format($giaThucTe, 0, ',', '.') }}₫
                    </div>
                @else
                    <!-- Giá thường -->
                    <div style="color: #555;">
                        {{ number_format($sanPham->gia, 0, ',', '.') }}₫
                    </div>
                @endif
            </div>

            <!-- Cột Thành tiền -->
            <div style="flex: 1.5; text-align: right; font-weight: 600; color: #333;">
                {{ number_format($giaThucTe * $item->so_luong, 0, ',', '.') }}₫
            </div>
        </div>
    @endforeach
</div>

        <div style="margin-top: 20px; text-align: right;">
            <div style="display: inline-block; min-width: 250px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding: 5px 0; border-bottom: 1px solid #f5f5f5;">
                    <span style="color: #888;">Tổng tiền hàng:</span>
                    <span style="color: #333;">{{ number_format($order->tong_tien, 0, ',', '.') }}₫</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding: 5px 0; border-bottom: 1px solid #f5f5f5;">
                    <span style="color: #888;">Phí vận chuyển:</span>
                    <span style="color: #333;">Miễn phí</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <span style="font-size: 16px; font-weight: 600; color: #333;">TỔNG THANH TOÁN:</span>
                    <span style="font-size: 24px; font-weight: 700; color: #ee4d2d;">
                        {{ number_format($order->tong_tien, 0, ',', '.') }}₫
                    </span>
                </div>
            </div>
        </div>

        <div style="text-align: right; margin-top: 30px; padding-top: 20px; border-top: 1px dashed #ddd;">
             @if($order->trang_thai == 2)
                <a href="{{ route('payment.cancel', $order->id) }}" class="btn btn-danger" style="background: #fff; border: 1px solid #dc3545; color: #dc3545; padding: 10px 25px; border-radius: 4px; font-weight: 600;">
                    Hủy đơn hàng
                </a>
            @endif
        </div>

    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
    <style>
        .payment-breadcrumb {
            background: #f5f5f5;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .payment-breadcrumb a {
            color: #0088cc;
        }

        .payment-breadcrumb .divider {
            color: #999;
            margin: 0 5px;
        }

        .payment-header {
            background: #fff;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            border-left: 4px solid #0088cc;
        }

        .payment-header h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .payment-header .order-id {
            color: #0088cc;
            font-weight: 600;
        }

        .qr-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .qr-card h4 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #333;
            font-size: 16px;
            font-weight: 600;
        }

        .qr-bank-info {
            background: #f9f9f9;
            padding: 8px 12px;
            border-radius: 3px;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .qr-bank-info strong {
            color: #0088cc;
        }

        .qr-image-wrap {
            background: #fff;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 4px;
            display: inline-block;
            margin: 15px 0;
        }

        .qr-image-wrap img {
            width: 100%;
            max-width: 280px;
            display: block;
        }

        .qr-amount {
            background: #d9edf7;
            border: 1px solid #bce8f1;
            padding: 10px 15px;
            border-radius: 3px;
            margin: 10px 0;
        }

        .qr-amount .amount-label {
            font-size: 13px;
            color: #31708f;
            margin-bottom: 3px;
        }

        .qr-amount .amount-value {
            color: #c00;
            font-size: 22px;
            font-weight: bold;
        }

        .qr-memo {
            background: #fcf8e3;
            border: 1px solid #fbeed5;
            padding: 8px 12px;
            border-radius: 3px;
            margin: 10px 0;
        }

        .qr-memo .memo-label {
            font-size: 12px;
            color: #8a6d3b;
            margin-bottom: 2px;
        }

        .qr-memo .memo-value {
            color: #0088cc;
            font-size: 14px;
            font-weight: bold;
            word-break: break-all;
        }

        .qr-warning {
            background: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
            padding: 8px 12px;
            border-radius: 3px;
            font-size: 12px;
            margin-top: 10px;
        }

        .order-detail-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .order-detail-card h4 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #333;
            font-size: 16px;
            font-weight: 600;
            border-bottom: 2px solid #0088cc;
            padding-bottom: 8px;
        }

        .order-table {
            margin-bottom: 15px;
            font-size: 13px;
        }

        .order-table thead {
            background: #f9f9f9;
        }

        .order-table thead th {
            padding: 8px 10px;
            font-weight: 600;
            font-size: 12px;
            color: #555;
        }

        .order-table tbody td {
            padding: 8px 10px;
            vertical-align: middle;
        }

        .order-table .total-row {
            background: #f5f5f5;
            font-weight: bold;
        }

        .order-table .total-row td {
            padding: 10px;
            font-size: 14px;
        }

        .order-table .total-amount {
            color: #c00;
            font-size: 16px;
        }

        .info-alert {
            background: #d9edf7;
            border: 1px solid #bce8f1;
            color: #31708f;
            padding: 10px 12px;
            border-radius: 3px;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .info-alert i {
            margin-right: 5px;
        }

        .timer-box {
            background: #fcf8e3;
            border: 1px solid #fbeed5;
            padding: 10px 12px;
            border-radius: 3px;
            text-align: center;
            margin-bottom: 15px;
        }

        .timer-box .timer-label {
            font-size: 12px;
            color: #8a6d3b;
            margin-bottom: 3px;
        }

        .timer-box .timer-value {
            font-size: 18px;
            font-weight: bold;
            color: #c00;
        }

        .action-buttons {
            text-align: right;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            margin-top: 15px;
        }

        .btn-payment-cancel {
            margin-right: 8px;
        }

        .alert-error-custom {
            background: #f2dede;
            border: 1px solid #ebccd1;
            color: #a94442;
            padding: 10px 12px;
            border-radius: 3px;
            margin-bottom: 15px;
            font-size: 13px;
        }
    </style>

    <!-- Breadcrumb -->
    <div class="payment-breadcrumb">
        <a href="{{ route('home') }}">Trang chủ</a>
        <span class="divider">/</span>
        <a href="{{ route('cart.index') }}">Giỏ hàng</a>
        <span class="divider">/</span>
        <span style="color: #333; font-weight: 600;">Thanh toán</span>
    </div>

    <div class="payment-header">
        <h3>
            <i class="icon-credit-card"></i> Thanh toán đơn hàng
            <span class="order-id">#{{ $donHang->id }}</span>
        </h3>
    </div>

    @if(session('error'))
        <div class="alert-error-custom">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="icon-exclamation-sign"></i> <strong>Lỗi!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Cột trái: Mã QR -->
        <div class="span4">
            <div class="qr-card">
                <h4><i class="icon-qrcode"></i> Quét mã QR để thanh toán</h4>

                <div class="qr-bank-info">
                    <i class="icon-home"></i> Ngân hàng: <strong>MB Bank</strong>
                </div>

                <div class="qr-image-wrap">
                    <img src="{{ $qrApiUrl }}" alt="Mã QR Thanh toán">
                </div>

                <div class="qr-amount">
                    <div class="amount-label">Tổng tiền thanh toán:</div>
                    <div class="amount-value">{{ number_format($totalMoney, 0, ',', '.') }}₫</div>
                </div>

                <div class="qr-memo">
                    <div class="memo-label">Nội dung chuyển khoản:</div>
                    <div class="memo-value">{{ $memo }}</div>
                </div>

                <div class="qr-warning">
                    <i class="icon-warning-sign"></i> Vui lòng nhập <strong>đúng nội dung</strong> chuyển khoản để đơn hàng
                    được xác nhận tự động.
                </div>
            </div>
        </div>

        <!-- Cột phải: Chi tiết đơn hàng -->
        <div class="span5">
            <div class="order-detail-card">
                <h4><i class="icon-list-alt"></i> Chi tiết đơn hàng</h4>

                <table class="table table-bordered table-condensed order-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th style="width: 80px;">SL</th>
                            <th style="width: 120px;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donHang->chiTietDonHang as $item)
                            <tr>
                                <td>{{ $item->sanPham->name }}</td>
                                <td style="text-align: center;">{{ $item->so_luong }}</td>
                                <td style="text-align: right;">
                                    {{ number_format($item->sanPham->gia * $item->so_luong, 0, ',', '.') }}₫</td>
                            </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="2" style="text-align:right;">TỔNG CỘNG:</td>
                            <td style="text-align: right;" class="total-amount">
                                {{ number_format($totalMoney, 0, ',', '.') }}₫</td>
                        </tr>
                    </tbody>
                </table>

                <div class="timer-box">
                    <div class="timer-label">
                        <i class="icon-time"></i> Thời gian còn lại:
                    </div>
                    <div class="timer-value" id="countdown">10:00</div>
                </div>

                <div class="info-alert">
                    <i class="icon-info-sign"></i> Sản phẩm đã được giữ cho bạn. Vui lòng thanh toán trong <strong>10
                        phút</strong> để hoàn tất đơn hàng.
                </div>

                <div class="action-buttons">
                    <a href="{{ route('payment.cancel', ['id' => $donHang->id]) }}"
                        class="btn btn-large btn-danger btn-payment-cancel"
                        onclick="return confirm('Bạn muốn hủy đơn này? Hàng sẽ được trả lại kho.')">
                        <i class="icon-remove icon-white"></i> Hủy đơn hàng
                    </a>

                    <a href="{{ route('payment.success', ['id' => $donHang->id]) }}" class="btn btn-large btn-success">
                        <i class="icon-ok icon-white"></i> Tôi đã thanh toán
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Countdown timer 10 phút
        let timeLeft = 600; // 10 phút = 600 giây

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            document.getElementById('countdown').textContent =
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                alert('Hết thời gian thanh toán! Đơn hàng sẽ tự động hủy.');
                window.location.href = "{{ route('payment.cancel', ['id' => $donHang->id]) }}";
            }

            timeLeft--;
        }

        // Cập nhật mỗi giây
        setInterval(updateTimer, 1000);
        updateTimer(); // Chạy ngay lần đầu
    </script>

@endsection
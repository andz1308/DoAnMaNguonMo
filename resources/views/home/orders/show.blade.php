@extends('layouts.app')

@section('content')
<div class="well well-small">
    <div class="row-fluid">
        <div class="span6">
            <h3>Đơn hàng #{{ $order->id }}</h3>
        </div>
        <div class="span6" style="text-align:right;">
            <a href="{{ route('user.orders.index') }}" class="btn btn-small">
                &laquo; Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <h4>Thông tin đơn hàng</h4>
            <ul class="unstyled">
                <li><strong>Trạng thái:</strong>
                    <span class="label 
                        @switch($order->trang_thai)
                            @case(\App\Models\DonHang::STATUS_COMPLETED) label-success @break
                            @case(\App\Models\DonHang::STATUS_PROCESSING) label-info @break
                            @case(\App\Models\DonHang::STATUS_CANCELLED) label-important @break
                            @default label-warning
                        @endswitch">
                        {{ $order->trang_thai_label }}
                    </span>
                </li>
                <li><strong>Ghi chú:</strong> {{ $order->ghi_chu ?? 'Không có' }}</li>
            </ul>
        </div>
        <div class="span6">
            <h4>Thông tin thanh toán</h4>
            <ul class="unstyled">
                <li><strong>Tổng tiền:</strong> {{ number_format($order->tong_tien, 0, ',', '.') }} VND</li>
                <li><strong>Ngày thanh toán:</strong>
                    {{ optional($order->thanhToan)->ngay_thanh_toan ? \Carbon\Carbon::parse($order->thanhToan->ngay_thanh_toan)->format('d/m/Y H:i') : 'Chưa thanh toán' }}
                </li>
            </ul>
        </div>
    </div>

    <hr>

    <h4>Sản phẩm trong đơn</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th class="text-center">Số lượng</th>
                <th class="text-right">Giá</th>
                <th class="text-right">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->chiTietDonHang as $item)
                <tr>
                    <td>
                        <div class="media">
                            @php
                                $imageName = $item->sanPham->images->first()->name
                                    ?? $item->sanPham->image
                                    ?? null;
                                $imageUrl = $imageName
                                    ? asset('uploads/images/san_pham/' . $imageName)
                                    : null;
                            @endphp
                            @if($imageUrl)
                                <img src="{{ $imageUrl }}" class="pull-left" style="width:60px; height:60px; margin-right:10px; object-fit:cover;" alt="{{ $item->sanPham->name ?? '' }}">
                            @endif
                            <div class="media-body">
                                <strong>{{ $item->sanPham->name ?? 'Sản phẩm đã xoá' }}</strong>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">{{ $item->so_luong }}</td>
                    <td class="text-right">{{ number_format($item->sanPham->gia ?? 0, 0, ',', '.') }} VND</td>
                    <td class="text-right">{{ number_format(($item->sanPham->gia ?? 0) * $item->so_luong, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


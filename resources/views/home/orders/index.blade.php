@extends('layouts.app')

@section('content')
<div class="well well-small">
    <h3>Đơn hàng của tôi</h3>

    <form class="orders-filter mb-3" method="GET" action="{{ route('user.orders.index') }}">
        <div class="filter-group">
            <label class="filter-label" for="searchOrder">Mã đơn / sản phẩm</label>
            <input type="text" id="searchOrder" name="search" class="filter-input"
                placeholder="Nhập mã sản phẩm hoặc mã đơn"
                value="{{ request('search') }}">
        </div>

        <div class="filter-group">
            <label class="filter-label" for="statusFilter">Trạng thái</label>
            <select name="status" id="statusFilter" class="filter-select">
                <option value="">Tất cả</option>
                @foreach($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected(request('status') !== null && request('status') !== '' && (int)request('status') === (int)$value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label class="filter-label" for="fromDate">Từ ngày thanh toán</label>
            <input type="date" id="fromDate" name="from_date" class="filter-input"
                value="{{ request('from_date') }}">
        </div>

        <div class="filter-group">
            <label class="filter-label" for="toDate">Đến ngày thanh toán</label>
            <input type="date" id="toDate" name="to_date" class="filter-input"
                value="{{ request('to_date') }}">
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary"><i class="icon-search"></i> Lọc</button>
            <a href="{{ route('user.orders.index') }}" class="btn btn-light">Xóa</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Ngày thanh toán</th>
                <th>Số sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        @if(optional($order->thanhToan)->ngay_thanh_toan)
                            {{ \Carbon\Carbon::parse($order->thanhToan->ngay_thanh_toan)->format('d/m/Y H:i') }}
                        @else
                            <span class="muted">Chưa thanh toán</span>
                        @endif
                    </td>
                    <td>{{ $order->chiTietDonHang->sum('so_luong') }}</td>
                    <td>{{ number_format($order->tong_tien, 0, ',', '.') }} VND</td>
                    <td>
                        <span class="label 
                            @switch($order->trang_thai)
                                @case(\App\Models\DonHang::STATUS_COMPLETED) label-success @break
                                @case(\App\Models\DonHang::STATUS_PROCESSING) label-info @break
                                @case(\App\Models\DonHang::STATUS_CANCELLED) label-important @break
                                @default label-warning
                            @endswitch">
                            {{ $order->trang_thai_label }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-mini btn-primary">
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-error">Bạn chưa có đơn hàng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination pagination-centered">
        {{ $orders->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .orders-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        padding: 12px 15px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .orders-filter .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 160px;
    }

    .orders-filter .filter-label {
        font-weight: 600;
        font-size: 13px;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .orders-filter .filter-input,
    .orders-filter .filter-select {
        height: 42px;
        padding: 8px 12px;
        border: 1px solid #bbb;
        border-radius: 6px;
        min-width: 200px;
        font-size: 14px;
    }

    .orders-filter .filter-actions {
        display: flex;
        align-items: flex-end;
        gap: 10px;
    }

    .orders-filter .btn-light {
        background: #fff;
        border: 1px solid #ccc;
        color: #555;
    }

    .orders-filter .btn-light:hover {
        background: #f0f0f0;
    }

    @media (max-width: 768px) {
        .orders-filter {
            flex-direction: column;
        }

        .orders-filter .filter-group,
        .orders-filter .filter-input,
        .orders-filter .filter-select {
            width: 100%;
            min-width: unset;
        }

        .orders-filter .filter-actions {
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>
@endpush


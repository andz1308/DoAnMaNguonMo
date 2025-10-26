@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-receipt me-2"></i>Danh sách đơn hàng</h4>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchOrder" placeholder="Tìm kiếm theo tên hoặc email khách hàng">
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary w-100" onclick="searchOrders()"><i class="fas fa-search me-2"></i>Tìm kiếm</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Số lượng mục</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                        <td>{{ $order->chiTietDonHang->count() }}</td>
                        <td>{{ number_format($order->thanhToan->tong_tien ?? 0) }} VND</td>
                        <td>{{ $order->trang_thai ?? 'N/A' }}</td>
                        <td>{{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.don_hang.show', $order->id ?? $order) }}" class="btn btn-sm btn-info">Xem</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Chưa có đơn hàng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($orders) && $orders->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>Hiển thị {{ $orders->firstItem() }} - {{ $orders->lastItem() }} / {{ $orders->total() }} đơn hàng</div>
            <div>{{ $orders->links() }}</div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function searchOrders(){
    const s = $('#searchOrder').val();
    const params = new URLSearchParams(); if(s) params.append('search', s);
    window.location.href = '{{ route("admin.don_hang.index") }}' + (params.toString() ? '?' + params.toString() : '');
}
</script>
@endpush

@endsection

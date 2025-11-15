@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-receipt me-2"></i>Danh sách đơn hàng</h4>
        </div>

        <form class="row g-3 mb-3" id="orderFilterForm">
            <div class="col-md-6 col-lg-5">
                <input type="text" class="form-control" id="searchOrder" name="search"
                    placeholder="Tìm kiếm theo mã, khách hàng, sản phẩm" value="{{ request('search') }}">
            </div>
            <div class="col-md-3 col-lg-3">
                <select class="form-select" id="filterStatus" name="status">
                    <option value="">Tất cả trạng thái</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') !== null && request('status') !== '' && (int)request('status') === (int)$value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-lg-2 d-grid">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search me-2"></i>Lọc</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Số lượng mục</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày thanh toán</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                        <td>{{ $order->chiTietDonHang->count() }}</td>
                        <td>{{ number_format($order->tong_tien, 0, ',', '.') }} VND</td>
                        <td>
                            <span class="badge 
                                @switch($order->trang_thai)
                                    @case(\App\Models\DonHang::STATUS_COMPLETED) bg-success @break
                                    @case(\App\Models\DonHang::STATUS_PROCESSING) bg-primary @break
                                    @case(\App\Models\DonHang::STATUS_CANCELLED) bg-danger @break
                                    @default bg-warning text-dark
                                @endswitch">
                                {{ $order->trang_thai_label }}
                            </span>
                            <select class="form-select form-select-sm mt-2 order-status-select"
                                data-order-id="{{ $order->id }}" data-current="{{ $order->trang_thai }}">
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($order->trang_thai === (int)$value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            @if(optional($order->thanhToan)->ngay_thanh_toan)
                                {{ \Carbon\Carbon::parse($order->thanhToan->ngay_thanh_toan)->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">Chưa thanh toán</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.don_hang.show', $order->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye me-1"></i>Xem
                            </a>
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

@endsection

@push('scripts')
<script>
    const statusClassMap = {
        {{ \App\Models\DonHang::STATUS_PENDING }}: 'bg-warning text-dark',
        {{ \App\Models\DonHang::STATUS_PROCESSING }}: 'bg-primary',
        {{ \App\Models\DonHang::STATUS_COMPLETED }}: 'bg-success',
        {{ \App\Models\DonHang::STATUS_CANCELLED }}: 'bg-danger'
    };
    const statusClassList = ['bg-warning', 'text-dark', 'bg-primary', 'bg-success', 'bg-danger', 'bg-secondary'];

    $('#orderFilterForm').on('submit', function () {
        const disabled = [];
        // Allow default submission, but trim empty fields before sending
        $(this).find('input, select').each(function () {
            if (!$(this).val()) {
                $(this).prop('disabled', true);
                disabled.push(this);
            }
        });

        setTimeout(function () {
            disabled.forEach(function (el) {
                $(el).prop('disabled', false);
            });
        }, 0);
    });

    $('.order-status-select').on('change', function () {
        const orderId = $(this).data('order-id');
        const status = $(this).val();

        updateOrderStatus(orderId, status, $(this));
    });

    function updateOrderStatus(orderId, status, $select) {
        $.ajax({
            url: `/admin/don-hang/${orderId}`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'PATCH',
                trang_thai: status
            },
            success: function (response) {
                if (response.status_label) {
                    const badge = $select.closest('td').find('.badge');
                    badge.text(response.status_label);
                    badge.removeClass(statusClassList.join(' '));
                    if (statusClassMap.hasOwnProperty(status)) {
                        badge.addClass(statusClassMap[status]);
                    } else {
                        badge.addClass('bg-secondary');
                    }
                }
                $select.data('current', parseInt(status, 10));
                setTimeout(function () {
                    window.location.reload();
                }, 300);
            },
            error: function () {
                alert('Không thể cập nhật trạng thái đơn hàng. Vui lòng thử lại sau.');
                $select.val($select.data('current'));
            }
        });
    }
</script>
@endpush

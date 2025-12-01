@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <!-- Header -->
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-receipt me-2 text-primary"></i>Danh sách đơn hàng
            </h5>
        </div>

        <div class="card-body">
            @php
                $quickStatusButtons = [
                    \App\Models\DonHang::STATUS_PENDING => 'btn-outline-warning text-dark',
                    \App\Models\DonHang::STATUS_PROCESSING => 'btn-outline-primary',
                    \App\Models\DonHang::STATUS_COMPLETED => 'btn-outline-success',
                    \App\Models\DonHang::STATUS_CANCELLED => 'btn-outline-danger',
                ];
                $statusTransitions = [
                    \App\Models\DonHang::STATUS_PENDING => [
                        \App\Models\DonHang::STATUS_PROCESSING,
                        \App\Models\DonHang::STATUS_CANCELLED,
                    ],
                    \App\Models\DonHang::STATUS_PROCESSING => [
                        \App\Models\DonHang::STATUS_COMPLETED,
                        \App\Models\DonHang::STATUS_CANCELLED,
                    ],
                    \App\Models\DonHang::STATUS_COMPLETED => [],
                    \App\Models\DonHang::STATUS_CANCELLED => [],
                    \App\Models\DonHang::STATUS_CART => [
                        \App\Models\DonHang::STATUS_PENDING,
                    ],
                ];
            @endphp

            <!-- Filter Form -->
            <form class="row g-3 mb-4" id="orderFilterForm">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchOrder" name="search"
                            placeholder="Tìm theo mã, khách hàng, sản phẩm..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3 col-lg-2">
                    <select class="form-select" id="filterStatus" name="status">
                        <option value="">Tất cả trạng thái</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(request('status') !== null && request('status') !== '' && (int)request('status') === (int)$value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" placeholder="Từ ngày">
                </div>
                <div class="col-md-3 col-lg-2">
                    <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" placeholder="Đến ngày">
                </div>
                <div class="col-md-3 col-lg-2 d-grid">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-filter me-2"></i>Lọc
                    </button>
                </div>
            </form>

            <!-- Orders Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;" class="text-center">ID</th>
                            <th style="width: 180px;">Khách hàng</th>
                            <th style="width: 100px;" class="text-center">SL mục</th>
                            <th style="width: 150px;">Tổng tiền</th>
                            <th style="width: 140px;">Trạng thái</th>
                            <th style="width: 150px;">Ngày TT</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders ?? [] as $order)
                        <tr>
                            @php
                                $availableStatuses = $statusTransitions[$order->trang_thai] ?? [];
                            @endphp
                            <td class="text-center">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">#{{ $order->id }}</span>
                            </td>
                            <td class="fw-semibold">{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                            <td class="text-center">
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    {{ $order->chiTietDonHang->count() }} mục
                                </span>
                            </td>
                            <td class="text-danger fw-bold">{{ number_format($order->tong_tien, 0, ',', '.') }} ₫</td>
                            <td>
                                <span class="badge 
                                    @switch($order->trang_thai)
                                        @case(\App\Models\DonHang::STATUS_COMPLETED) bg-success @break
                                        @case(\App\Models\DonHang::STATUS_PROCESSING) bg-primary @break
                                        @case(\App\Models\DonHang::STATUS_CANCELLED) bg-danger @break
                                        @default bg-warning text-dark
                                    @endswitch">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                    {{ $order->trang_thai_label }}
                                </span>
                            </td>
                            <td>
                                @if(optional($order->thanhToan)->ngay_thanh_toan)
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($order->thanhToan->ngay_thanh_toan)->format('d/m/Y H:i') }}
                                    </small>
                                @else
                                    <span class="text-muted">
                                        <i class="far fa-clock me-1"></i>Chưa thanh toán
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap gap-2 align-items-center justify-content-center">
                                    @if(count($availableStatuses))
                                        <div class="btn-group btn-group-sm order-status-actions" role="group">
                                            @foreach($availableStatuses as $value)
                                                @continue(!isset($quickStatusButtons[$value], $statusOptions[$value]))
                                                <button type="button"
                                                    class="btn {{ $quickStatusButtons[$value] }} order-status-btn"
                                                    data-order-id="{{ $order->id }}"
                                                    data-status="{{ $value }}"
                                                    data-bs-toggle="tooltip"
                                                    title="Chuyển sang: {{ $statusOptions[$value] }}">
                                                    {{ $statusOptions[$value] }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                    <a href="{{ route('admin.don_hang.show', $order->id) }}" 
                                       class="btn btn-sm btn-info"
                                       data-bs-toggle="tooltip"
                                       title="Xem chi tiết">
                                        <i class="fas fa-eye me-1"></i>Chi tiết
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 opacity-25 d-block"></i>
                                <h6 class="text-muted">Chưa có đơn hàng nào</h6>
                                <p class="text-muted mb-0 small">Đơn hàng sẽ hiển thị ở đây</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(isset($orders) && $orders->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Hiển thị {{ $orders->firstItem() }} - {{ $orders->lastItem() }} trong tổng số {{ $orders->total() }} đơn hàng
                </div>
                <div class="pagination-wrapper">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Fix pagination size */
    .pagination-wrapper .pagination {
        margin-bottom: 0;
    }
    
    .pagination-wrapper .page-link {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .pagination-wrapper .page-item:first-child .page-link,
    .pagination-wrapper .page-item:last-child .page-link {
        border-radius: 0.25rem;
    }

    /* Input group styling */
    .input-group-text.border-end-0 {
        background-color: #f8f9fa;
    }
    
    .form-control.border-start-0:focus {
        border-left: 1px solid #86b7fe;
    }

    /* Table hover effect */
    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    /* Order actions column spacing */
    .order-actions-row {
        min-width: 200px;
    }

    /* Status buttons styling */
    .order-status-btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        white-space: nowrap;
    }

    .order-status-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

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

    $('.order-status-btn').on('click', function () {
        const $btn = $(this);
        if ($btn.prop('disabled')) {
            return;
        }

        const orderId = $btn.data('order-id');
        const status = $btn.data('status');
        const $group = $btn.closest('.order-status-actions');

        updateOrderStatus(orderId, status, $btn, $group);
    });

    function updateOrderStatus(orderId, status, $button, $group) {
        $group.find('button').prop('disabled', true);

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
                    const badge = $button.closest('tr').find('td:nth-child(5) .badge');
                    badge.text(response.status_label);
                    badge.removeClass(statusClassList.join(' '));
                    const statusKey = parseInt(status, 10);
                    if (statusClassMap.hasOwnProperty(statusKey)) {
                        badge.addClass(statusClassMap[statusKey]);
                    } else {
                        badge.addClass('bg-secondary');
                    }
                }
                setTimeout(function () {
                    window.location.reload();
                }, 300);
            },
            error: function () {
                alert('Không thể cập nhật trạng thái đơn hàng. Vui lòng thử lại sau.');
                $group.find('button').prop('disabled', false);
            }
        });
    }
</script>
@endpush
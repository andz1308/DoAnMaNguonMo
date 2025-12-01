@extends('admin.layouts.app')

@section('title', 'Báo cáo thống kê')
@section('page-title', 'Báo cáo thống kê')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-muted mb-0">
            Dữ liệu từ:
            <span class="text-dark fw-bold">{{ $startDate->format('d/m/Y') }}</span>
            đến
            <span class="text-dark fw-bold">{{ $endDate->format('d/m/Y') }}</span>
        </h5>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-muted">Đơn hàng (Theo bộ lọc)</h6>
                <h3 class="text-primary">{{ number_format($totalOrders) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-muted">Tổng người dùng (Toàn hệ thống)</h6>
                <h3 class="text-success">{{ number_format($totalUsers) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm h-100">
                <h6 class="text-muted">Doanh thu (Theo bộ lọc)</h6>
                <h3 class="text-danger">{{ number_format($totalRevenue ?? 0) }} VND</h3>
            </div>
        </div>
    </div>

    <div class="card mb-4 p-3 border-0 shadow-sm">
        <form class="row g-2 align-items-end" method="GET" action="{{ route('admin.reports.index') }}">
            <div class="col-md-3">
                <label class="form-label">Bắt đầu</label>
                <input type="date" name="start_date" class="form-control"
                    value="{{ request('start_date') ?? $startDate->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Kết thúc</label>
                <input type="date" name="end_date" class="form-control"
                    value="{{ request('end_date') ?? $endDate->format('Y-m-d') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Chu kỳ</label>
                <select name="period" class="form-select">
                    <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Theo Ngày</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Theo Tháng</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Theo Năm</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="fas fa-filter"></i> Lọc
                </button>
                <button type="submit" name="view_all" value="1" class="btn btn-secondary flex-grow-1">
                    <i class="fas fa-list"></i> Hiện tất cả
                </button>
            </div>
        </form>
    </div>

    <div class="card mb-4 p-3 border-0 shadow-sm">
        <h5 class="card-title">Biểu đồ số lượng đơn hàng thanh toán</h5>
        <div style="height: 300px;"> <canvas id="ordersChart"></canvas>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-muted mb-0">Top sản phẩm bán chạy</h5>
                    <small class="text-muted fst-italic">(Theo số lượng bán ra)</small>
                </div>
                <div class="card-body p-0 overflow-auto" style="max-height: 500px;">
                    <div class="list-group list-group-flush">
                        @forelse($topProducts as $index => $product)
                            <div class="list-group-item d-flex align-items-center py-3">
                                <div class="me-3">
                                    @if($index == 0)
                                        <span class="badge bg-warning text-dark rounded-circle p-2 shadow-sm" style="width: 32px; height: 32px;">1</span>
                                    @elseif($index == 1)
                                        <span class="badge bg-secondary rounded-circle p-2 shadow-sm" style="width: 32px; height: 32px;">2</span>
                                    @elseif($index == 2)
                                        <span class="badge bg-secondary bg-opacity-75 rounded-circle p-2 shadow-sm" style="width: 32px; height: 32px;">3</span>
                                    @else
                                        <span class="badge bg-light text-muted border rounded-circle p-2" style="width: 32px; height: 32px;">{{ $index + 1 }}</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 text-truncate" style="max-width: 140px;" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h6>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-coins text-warning"></i>
                                        {{ number_format($product->tong_doanh_thu) }} ₫
                                    </small>
                                </div>
                                <div class="text-end ps-2">
                                    <h5 class="text-primary fw-bold mb-0">{{ $product->tong_so_luong }}</h5>
                                    <small class="text-muted" style="font-size: 11px;">Đã bán</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-light mb-3"></i>
                                <p class="text-muted">Chưa có dữ liệu</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title text-muted mb-0">Giao dịch gần đây</h5>
                    <small class="text-muted fst-italic">(Các đơn hàng đã thanh toán)</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Mã ĐH</th>
                                    <th>Khách hàng</th>
                                    <th>Số tiền</th>
                                    <th>Thời gian</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $o)
                                    <tr>
                                        <td>#{{ $o->id }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $o->user->name ?? 'Khách vãng lai' }}</div>
                                            <small class="text-muted">{{ $o->user->email ?? '' }}</small>
                                        </td>
                                        <td class="text-danger fw-bold">
                                            {{ number_format($o->thanhToan->tong_tien ?? 0) }} ₫
                                        </td>
                                        <td>
                                            @if($o->thanhToan)
                                                {{ \Carbon\Carbon::parse($o->thanhToan->ngay_thanh_toan)->format('d/m H:i') }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Đã TT</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="text-muted mb-0">Không có dữ liệu</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center py-3">
                     <a href="#" class="text-decoration-none small">Xem tất cả đơn hàng &rarr;</a>
                </div>
            </div>
        </div>

    </div> </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const labels = {!! $chartLabels ?? '[]' !!};
            const data = {!! $chartData ?? '[]' !!};

            const ctx = document.getElementById('ordersChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Đơn hàng đã thanh toán',
                        data: data,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0d6efd',
                        pointHoverBackgroundColor: '#0d6efd',
                        pointHoverBorderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Quan trọng để chỉnh height trong div cha
                    plugins: {
                        legend: { display: false }, // Ẩn legend nếu muốn gọn
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            grid: { display: false } // Ẩn lưới dọc cho đẹp
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });
        });
    </script>
@endpush
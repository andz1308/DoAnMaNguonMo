@extends('admin.layouts.app')

@section('title', 'Báo cáo thống kê')
@section('page-title', 'Báo cáo thống kê')

@section('content')
<div class="container-fluid">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Tổng đơn hàng</h6>
                <h3>{{ number_format($totalOrders) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Tổng người dùng</h6>
                <h3>{{ number_format($totalUsers) }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Tổng doanh thu</h6>
                <h3>{{ number_format($totalRevenue ?? 0) }} VND</h3>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="card mb-4 p-3">
            <form class="row g-2 align-items-end" method="GET" action="{{ route('admin.reports.index') }}">
                <div class="col-md-3">
                    <label class="form-label">Bắt đầu</label>
                    <input type="date" name="start_date" class="form-control" value="{{ optional($startDate)->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kết thúc</label>
                    <input type="date" name="end_date" class="form-control" value="{{ optional($endDate)->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Chu kỳ</label>
                    <select name="period" class="form-select">
                        <option value="daily" {{ (isset($period) && $period=='daily') ? 'selected' : '' }}>Ngày</option>
                        <option value="monthly" {{ (isset($period) && $period=='monthly') ? 'selected' : '' }}>Tháng</option>
                        <option value="yearly" {{ (isset($period) && $period=='yearly') ? 'selected' : '' }}>Năm</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100">Cập nhật</button>
                </div>
            </form>
        </div>

        <div class="card mb-4 p-3">
            <canvas id="ordersChart" height="120"></canvas>
        </div>

        <h5>Đơn hàng gần đây</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Tổng</th>
                        <th>Ngày</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders ?? [] as $o)
                    <tr>
                        <td>{{ $o->id }}</td>
                        <td>{{ $o->user->name ?? 'Khách' }}</td>
                        <td>{{ number_format($o->thanhToan->tong_tien ?? 0) }} VND</td>
                        <td>{{ $o->created_at ? $o->created_at->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center">Không có đơn hàng nào</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function(){
        const labels = {!! $chartLabels ?? '[]' !!};
        const data = {!! $chartData ?? '[]' !!};

        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số đơn hàng',
                    data: data,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78,115,223,0.1)',
                    tension: 0.3,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    x: { display: true },
                    y: { display: true, beginAtZero: true }
                }
            }
        });
    })();
</script>
@endpush

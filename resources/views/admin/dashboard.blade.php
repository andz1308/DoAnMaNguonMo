@extends('admin.layouts.app')

@section('title', 'Trang chủ Admin')
@section('page-title', 'Trang chủ')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Người dùng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers ?? 0 }}</div>
                    </div>
                    <div class="card-icon text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Sản phẩm
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts ?? 0 }}</div>
                    </div>
                    <div class="card-icon text-success">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Đánh giá
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReviews ?? 0 }}</div>
                    </div>
                    <div class="card-icon text-warning">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Quick Links -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.don_hang.index') }}" class="text-decoration-none">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Đơn hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders ?? 0 }}</div>
                        </div>
                        <div class="card-icon text-primary"><i class="fas fa-shopping-cart"></i></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.khuyen_mai.index') }}" class="text-decoration-none">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Khuyến mãi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPromotions ?? 0 }}</div>
                        </div>
                        <div class="card-icon text-primary"><i class="fas fa-tags"></i></div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.reports.index') }}" class="text-decoration-none">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Báo cáo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Xem báo cáo</div>
                        </div>
                        <div class="card-icon text-primary"><i class="fas fa-chart-bar"></i></div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Recent Reviews -->
        <div class="col-lg-6 mb-4">
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-star text-warning me-2"></i>Đánh giá gần đây</h5>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Người dùng</th>
                                <th>Sản phẩm</th>
                                <th>Đánh giá</th>
                                <th>Ngày</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReviews ?? [] as $review)
                            <tr>
                                <td>{{ $review->user->name ?? 'N/A' }}</td>
                                <td>{{ Str::limit($review->sanPham->ten_san_pham ?? 'N/A', 30) }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= ($review->so_sao ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </td>
                                <td>{{ $review->created_at ? $review->created_at->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Chưa có đánh giá nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="row">
        <div class="col-12">
            <div class="table-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0"><i class="fas fa-users text-primary me-2"></i>Người dùng mới đăng ký</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Ngày đăng ký</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers ?? [] as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $user->role->ten_role ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td>
                                    @if($user->trang_thai ?? 1)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Bị khóa</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Chưa có người dùng mới</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

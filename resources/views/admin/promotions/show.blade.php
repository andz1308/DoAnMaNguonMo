@extends('admin.layouts.app')

@section('title', 'Chi tiết khuyến mãi')
@section('page-title', 'Chi tiết khuyến mãi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>{{ $promotion->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Tên khuyến mãi</label>
                            <p class="h5">{{ $promotion->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Giá trị giảm</label>
                            <p class="h5">
                                <span class="badge bg-success">{{ $promotion->gia }}%</span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">
                        <i class="fas fa-box me-2"></i>Sản phẩm áp dụng
                    </h6>

                    @if($promotion->chiTietKhuyenMais->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá gốc</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($promotion->chiTietKhuyenMais as $ct)
                                        @php
                                            $sanPham = \App\Models\SanPham::find($ct->san_pham_id);
                                        @endphp
                                        <tr>
                                            <td>{{ $ct->san_pham_id }}</td>
                                            <td>
                                                <a href="{{ route('admin.san_pham.show', $ct->san_pham_id) }}" class="text-decoration-none">
                                                    {{ $sanPham->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>{{ number_format($sanPham->gia ?? 0) }}₫</td>
                                            <td>
                                                @if($ct->ngay_bd)
                                                    <small class="badge bg-info">{{ $ct->ngay_bd->format('d/m/Y') }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ct->ngay_kt)
                                                    <small class="badge bg-warning text-dark">{{ $ct->ngay_kt->format('d/m/Y') }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Chưa có sản phẩm nào áp dụng khuyến mãi này
                        </div>
                    @endif

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.khuyen_mai.edit', $promotion->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa
                        </a>
                        <form action="{{ route('admin.khuyen_mai.destroy', $promotion->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa khuyến mãi này?')">
                                <i class="fas fa-trash me-2"></i>Xóa
                            </button>
                        </form>
                        <a href="{{ route('admin.khuyen_mai.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Thống kê
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Tổng sản phẩm áp dụng</label>
                        <p class="h4 mb-0">
                            <span class="badge bg-primary">{{ $promotion->chiTietKhuyenMais->count() }}</span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Mức giảm giá</label>
                        <p class="h4 mb-0">
                            <span class="badge bg-success">{{ $promotion->gia }}%</span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Trạng thái</label>
                        <p class="mb-0">
                            @php
                                $now = now();
                                $chiTietFirst = $promotion->chiTietKhuyenMais->first();
                                if ($chiTietFirst) {
                                    if ($now < $chiTietFirst->ngay_bd) {
                                        $status = 'Chưa bắt đầu';
                                        $badgeClass = 'bg-secondary';
                                    } elseif ($now > $chiTietFirst->ngay_kt) {
                                        $status = 'Đã kết thúc';
                                        $badgeClass = 'bg-danger';
                                    } else {
                                        $status = 'Đang diễn ra';
                                        $badgeClass = 'bg-success';
                                    }
                                } else {
                                    $status = 'Chưa có sản phẩm';
                                    $badgeClass = 'bg-warning';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar me-2"></i>Thời gian
                    </h5>
                </div>
                <div class="card-body">
                    @if($promotion->chiTietKhuyenMais->count() > 0)
                        @php
                            $ngayBd = $promotion->chiTietKhuyenMais->first()->ngay_bd;
                            $ngayKt = $promotion->chiTietKhuyenMais->first()->ngay_kt;
                        @endphp
                        <small class="text-muted">Ngày bắt đầu</small>
                        <p class="mb-2">{{ $ngayBd ? $ngayBd->format('d/m/Y') : 'N/A' }}</p>

                        <small class="text-muted">Ngày kết thúc</small>
                        <p>{{ $ngayKt ? $ngayKt->format('d/m/Y') : 'N/A' }}</p>
                    @else
                        <p class="text-muted">Chưa có thời gian áp dụng</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
    }
    
    .card-header {
        border-bottom: 2px solid #f0f0f0;
    }
    
    .table-light {
        background-color: #f8f9fa;
    }
</style>
@endsection

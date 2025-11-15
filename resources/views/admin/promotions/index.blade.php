@extends('admin.layouts.app')

@section('title', 'Quản lý khuyến mãi')
@section('page-title', 'Quản lý khuyến mãi')

@section('content')
<div class="container-fluid">
    <div class="table-container">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-tags me-2"></i>Danh sách khuyến mãi</h4>
            <a href="{{ route('admin.khuyen_mai.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Thêm khuyến mãi
            </a>
        </div>

        <form action="{{ route('admin.khuyen_mai.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="search" 
                        name="search" 
                        placeholder="Tìm kiếm tên khuyến mãi..." 
                        value="{{ request('search') }}"
                    >
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="fas fa-search me-2"></i>Tìm kiếm
                    </button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.khuyen_mai.index') }}" class="btn btn-light w-100">
                            <i class="fas fa-times me-2"></i>Xóa bộ lọc
                        </a>
                    </div>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 35%">Tên khuyến mãi</th>
                        <th style="width: 15%">Giá trị giảm</th>
                        <th style="width: 15%">Sản phẩm áp dụng</th>
                        <th style="width: 15%">Ngày tạo</th>
                        <th style="width: 15%" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotions ?? [] as $p)
                    <tr>
                        <td><strong>#{{ $p->id }}</strong></td>
                        <td>{{ $p->name }}</td>
                        <td>
                            <span class="badge bg-success">{{ $p->gia }}%</span>
                        </td>
                        <td>
                            @php
                                $count = $p->chiTietKhuyenMais()->count();
                            @endphp
                            <span class="badge bg-info">{{ $count }} sản phẩm</span>
                        </td>
                        <td>
                            @if($p->created_at)
                                <small>{{ $p->created_at->format('d/m/Y H:i') }}</small>
                            @else
                                <small class="text-muted">N/A</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.khuyen_mai.show', $p->id) }}" class="btn btn-info" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.khuyen_mai.edit', $p->id) }}" class="btn btn-warning" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.khuyen_mai.destroy', $p->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Xác nhận xóa khuyến mãi này?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox me-2"></i>Chưa có khuyến mãi nào
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($promotions) && $promotions->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <small class="text-muted">
                    Hiển thị <strong>{{ $promotions->firstItem() }}</strong> - 
                    <strong>{{ $promotions->lastItem() }}</strong> / 
                    <strong>{{ $promotions->total() }}</strong> khuyến mãi
                </small>
            </div>
            <nav>{{ $promotions->links() }}</nav>
        </div>
        @endif
    </div>
</div>

<style>
    .table-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table-light thead {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35rem 0.65rem;
    }
    
    .form-control {
        border: 1px solid #d0d0d0;
    }
    
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
</style>

@push('scripts')
<script>
    // Xác nhận xóa
    function confirmDelete(id) {
        return confirm('Bạn chắc chắn muốn xóa khuyến mãi này?');
    }
</script>
@endpush

@endsection

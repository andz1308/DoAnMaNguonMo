@extends('admin.layouts.app')

@section('title', 'Quản lý khuyến mãi')
@section('page-title', 'Quản lý khuyến mãi')

@section('content')
<div class="container-fluid">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-tags me-2"></i>Danh sách khuyến mãi</h4>
            <a href="#" class="btn btn-primary">Thêm khuyến mãi</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="searchPromo" placeholder="Tìm kiếm khuyến mãi">
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary w-100" onclick="searchPromos()"><i class="fas fa-search me-2"></i>Tìm kiếm</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotions ?? [] as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ number_format($p->gia ?? 0) }}</td>
                        <td>{{ $p->created_at ? $p->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-info">Xem</a>
                            <a href="#" class="btn btn-sm btn-warning">Sửa</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Chưa có khuyến mãi nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($promotions) && $promotions->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>Hiển thị {{ $promotions->firstItem() }} - {{ $promotions->lastItem() }} / {{ $promotions->total() }}</div>
            <div>{{ $promotions->links() }}</div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function searchPromos(){
    const s = $('#searchPromo').val();
    const params = new URLSearchParams(); if(s) params.append('search', s);
    window.location.href = '{{ route("admin.khuyen_mai.index") }}' + (params.toString() ? '?' + params.toString() : '');
}
</script>
@endpush

@endsection

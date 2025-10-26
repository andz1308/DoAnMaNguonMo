@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="container-fluid">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-boxes me-2"></i>Danh sách sản phẩm</h4>
            <a href="{{ route('admin.san_pham.create') }}" class="btn btn-success"><i class="fas fa-plus me-2"></i>Thêm mới</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchProduct" placeholder="Tìm kiếm theo tên, mô tả...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterLoai">
                    <option value="">Tất cả loại</option>
                    @foreach($loai ?? [] as $l)
                        <option value="{{ $l->id }}">{{ $l->name ?? $l->ten_loai ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary w-100" onclick="searchProducts()"><i class="fas fa-search me-2"></i>Tìm kiếm</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Loại</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($item->gia) }} VND</td>
                        <td>{{ $item->so_luong_con }}</td>
                        <td>{{ $item->loaiSanPham->name ?? 'N/A' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.san_pham.edit', $item) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('admin.san_pham.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Không có sản phẩm nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($data) && $data->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>Hiển thị {{ $data->firstItem() }} - {{ $data->lastItem() }} / {{ $data->total() }} sản phẩm</div>
            <div>{{ $data->links() }}</div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function searchProducts(){
    const s = $('#searchProduct').val();
    const l = $('#filterLoai').val();
    const params = new URLSearchParams(); if(s) params.append('search', s); if(l) params.append('loai', l);
    window.location.href = '{{ route("admin.san_pham.index") }}' + (params.toString() ? '?' + params.toString() : '');
}
</script>
@endpush

@endsection
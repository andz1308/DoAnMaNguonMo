@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Danh sách Sản phẩm</h1>
            <a href="{{ route('admin.san_pham.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-2"></i>Thêm mới
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center" style="width: 80px;">#</th>
                                <th scope="col" style="width: 80px;">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col" style="width: 150px;">Giá</th>
                                <th scope="col" class="text-center" style="width: 120px;">Số lượng</th>
                                <th scope="col" style="width: 180px;">Loại sản phẩm</th>
                                <th scope="col" class="text-center" style="width: 150px;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <th scope="row" class="text-center">{{ $item->id }}</th>
                                    <td>
                                        @php
                                            $imageName = $item->images->first()->name ?? $item->image ?? null;
                                            $imageUrl = $imageName ? asset('uploads/images/san_pham/' . $imageName) : null;
                                        @endphp
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" 
                                                 alt="{{ $item->name }}" 
                                                 class="img-thumbnail"
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 8px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $item->name }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($item->gia) }} ₫</td>
                                    <td class="text-center">
                                        <span class="badge {{ $item->so_luong_con > 10 ? 'bg-success' : ($item->so_luong_con > 0 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ $item->so_luong_con }}
                                        </span>
                                    </td>
                                    <td>{{ $item->loaiSanPham->name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.san_pham.edit', $item) }}" class="btn btn-warning btn-sm me-1">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.san_pham.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-25"></i>
                                        <p class="text-muted mb-0">Không có sản phẩm nào.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Phân trang với kích thước nhỏ hơn --}}
            @if($data->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Hiển thị {{ $data->firstItem() }} - {{ $data->lastItem() }} trong tổng số {{ $data->total() }} sản phẩm
                        </div>
                        <div class="pagination-wrapper">
                            {{ $data->links('pagination::bootstrap-4') }}
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

        /* Hover effect for table rows */
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
    </style>
@endsection
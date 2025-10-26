@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Danh sách Sản phẩm</h1>
<<<<<<< HEAD
        <a href="{{ route('admin.san-pham.create') }}" class="btn btn-success">Thêm mới</a>
=======
        <a href="{{ route('admin.san_pham.create') }}" class="btn btn-success">Thêm mới</a>
>>>>>>> origin/longvu
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Giá</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Loại sản phẩm</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <th scope="row">{{ $item->id }}</th>
<<<<<<< HEAD
                    <td>{{ $item->Name }}</td>
                    <td>{{ number_format($item->Gia) }} VND</td>
                    <td>{{ $item->SoLuongCon }}</td>
                    <td>{{ $item->loaiSanPham->Name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.san-pham.edit', $item) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.san-pham.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
=======
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->gia) }} VND</td>
                    <td>{{ $item->so_luong_con }}</td>
                    <td>{{ $item->loaiSanPham->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.san_pham.edit', $item) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.san_pham.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
>>>>>>> origin/longvu
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Không có sản phẩm nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Hiển thị phân trang --}}
    {{ $data->links() }}
@endsection
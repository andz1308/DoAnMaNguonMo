@extends('admin.layouts.app')

@section('content')
    <h1>Cập nhật Sản phẩm: {{ $sanPham->name }}</h1>

    {{-- Hiển thị lỗi validation --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.san_pham.update', $sanPham->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Phương thức PUT cho update --}}

        {{-- Các trường thông tin sản phẩm (dùng PascalCase cho name/id) --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $sanPham->name) }}">
        </div>
        <div class="mb-3">
            <label for="gia" class="form-label">Giá</label>
            <input type="number" class="form-control" id="gia" name="gia" value="{{ old('gia', $sanPham->gia) }}">
        </div>
        <div class="mb-3">
            <label for="gioi_thieu" class="form-label">Giới thiệu</label>
            <textarea class="form-control" id="gioi_thieu" name="gioi_thieu"
                rows="2">{{ old('gioi_thieu', $sanPham->gioi_thieu) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="10">{{ old('mo_ta', $sanPham->mo_ta) }}</textarea>
            {{-- TinyMCE/CKEditor sẽ áp dụng vào đây --}}
        </div>
        <div class="mb-3">
            <label for="thuong_hieu" class="form-label">Thương hiệu</label>
            <input type="text" class="form-control" id="thuong_hieu" name="thuong_hieu"
                value="{{ old('thuong_hieu', $sanPham->thuong_hieu) }}">
        </div>
        {{-- Thêm các input tương tự cho: ManHinh, DoPhangiai, Camera, Cpu, Pin, NgayPhatHanh, DungLuong, KichThuoc,
        TrongLuong --}}
        <div class="mb-3">
            <label for="so_luong_con" class="form-label">Số lượng còn</label>
            <input type="number" class="form-control" id="so_luong_con" name="so_luong_con"
                value="{{ old('so_luong_con', $sanPham->so_luong_con) }}">
        </div>
        <div class="mb-3">
            <label for="loai_san_pham_id" class="form-label">Loại sản phẩm</label>
            <select class="form-select" id="loai_san_pham_id" name="loai_san_pham_id">
                @foreach ($loaiSanPhams as $loai)
                    <option value="{{ $loai->id }}" {{ old('loai_san_pham_id', $sanPham->loai_san_pham_id) == $loai->id ? 'selected' : '' }}>
                        {{ $loai->name }} {{-- Giả sử tên cột là name --}}
                    </option>
                @endforeach
            </select>
        </div>

        <hr>

        {{-- Hiển thị ảnh hiện tại --}}
        {{-- Phần hiển thị và chọn xóa ảnh hiện tại --}}
        @if($sanPham->images->count() > 0)
            <div class="mb-3">
                <p>Ảnh hiện tại (Chọn ảnh bạn muốn xóa):</p>
                <div class="d-flex flex-wrap">
                    @foreach($sanPham->images as $image)
                        <div class="me-3 mb-3 text-center border p-2 rounded">
                            <img src="{{ asset('uploads/images/san_pham/' . $image->name) }}" {{-- Giả sử cột tên là Name --}}
                                 alt="Ảnh sản phẩm"
                                 class="img-thumbnail d-block mb-2"
                                 style="max-width: 100px; height: auto;">
                            <div class="form-check">
                                {{-- Checkbox để đánh dấu xóa ảnh này --}}
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="delete_images[]" {{-- Gửi đi một mảng ID ảnh cần xóa --}}
                                       value="{{ $image->id }}"
                                       id="delete_image_{{ $image->id }}">
                                <label class="form-check-label" for="delete_image_{{ $image->id }}">
                                    Xóa ảnh này
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Phần thêm ảnh mới --}}
        <div class="mb-3">
            <label for="HinhAnh" class="form-label">Thêm ảnh mới (Có thể chọn nhiều ảnh)</label>
            <input class="form-control" type="file" id="HinhAnh" name="HinhAnh[]" multiple>
        </div>

        {{-- ... (Phần còn lại của form chính) ... --}}


        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.san_pham.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection

@push('scripts')
    // Nếu bạn làm chức năng xóa ảnh bằng JS
    <script>
        function deleteImage(imageId) {
            if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
                // Gửi request xóa ảnh bằng AJAX hoặc form riêng
            }
        }
    </script>
@endpush
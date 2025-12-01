@extends('admin.layouts.app')

@section('content')
    <h1>Thêm mới Sản phẩm</h1>

    {{-- Hiển thị lỗi từ Server (Controller trả về) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.san_pham.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="gia" class="form-label">Giá <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="gia" name="gia" step="0.01" value="{{ old('gia') }}" required>
        </div>

        <div class="mb-3">
            <label for="gioi_thieu" class="form-label">Giới thiệu <span class="text-danger">*</span></label>
            <textarea class="form-control" id="gioi_thieu" name="gioi_thieu" rows="3" required>{{ old('gioi_thieu') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả chi tiết <span class="text-danger">*</span></label>
            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="5" required>{{ old('mo_ta') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="thuong_hieu" class="form-label">Thương hiệu <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="thuong_hieu" name="thuong_hieu" value="{{ old('thuong_hieu') }}" required>
        </div>

        <div class="mb-3">
            <label for="man_hinh" class="form-label">Màn hình <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="man_hinh" name="man_hinh" value="{{ old('man_hinh') }}" required>
        </div>

        <div class="mb-3">
            <label for="do_phan_giai" class="form-label">Độ phân giải <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="do_phan_giai" name="do_phan_giai" value="{{ old('do_phan_giai') }}" required>
        </div>

        <div class="mb-3">
            <label for="camera" class="form-label">Camera <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="camera" name="camera" value="{{ old('camera') }}" required>
        </div>

        <div class="mb-3">
            <label for="cpu" class="form-label">CPU <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="cpu" name="cpu" value="{{ old('cpu') }}" required>
        </div>

        <div class="mb-3">
            <label for="pin" class="form-label">Pin <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="pin" name="pin" value="{{ old('pin') }}" required>
        </div>

        <div class="mb-3">
            <label for="ngay_phat_hanh" class="form-label">Ngày phát hành <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="ngay_phat_hanh" name="ngay_phat_hanh"
                value="{{ old('ngay_phat_hanh') }}" required>
        </div>

        <div class="mb-3">
            <label for="dung_luong" class="form-label">Dung lượng <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="dung_luong" name="dung_luong" value="{{ old('dung_luong') }}" required>
        </div>

        <div class="mb-3">
            <label for="kich_thuoc" class="form-label">Kích thước <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="kich_thuoc" name="kich_thuoc" value="{{ old('kich_thuoc') }}" required>
        </div>

        <div class="mb-3">
            <label for="trong_luong" class="form-label">Trọng lượng <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="trong_luong" name="trong_luong" value="{{ old('trong_luong') }}" required>
        </div>

        <div class="mb-3">
            <label for="so_luong_con" class="form-label">Số lượng còn <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="so_luong_con" name="so_luong_con"
                value="{{ old('so_luong_con') }}" required>
        </div>

        <div class="mb-3">
            <label for="loai_san_pham_id" class="form-label">Loại sản phẩm <span class="text-danger">*</span></label>
            <select class="form-select" id="loai_san_pham_id" name="loai_san_pham_id" required>
                {{-- Quan trọng: thêm value="" để required hoạt động đúng --}}
                <option value="" selected disabled>-- Chọn loại sản phẩm --</option>
                @foreach ($loaiSanPhams as $loai)
                    <option value="{{ $loai->id }}">{{ $loai->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="HinhAnh" class="form-label">Hình ảnh (Có thể chọn nhiều ảnh) <span class="text-danger">*</span></label>
            <input class="form-control" type="file" id="HinhAnh" name="HinhAnh[]" multiple required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{ route('admin.san_pham.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
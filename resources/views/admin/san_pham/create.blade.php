@extends('admin.layouts.app')

@section('content')
    <h1>Thêm mới Sản phẩm</h1>

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
        {{-- Đảm bảo name dùng snake_case --}}
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="gia" class="form-label">Giá</label>
            <input type="number" class="form-control" id="gia" name="gia" step="0.01" value="{{ old('gia') }}"> {{-- Thêm
            step nếu giá có thể là số thập phân --}}
        </div>
        <div class="mb-3">
            <label for="gioi_thieu" class="form-label">Giới thiệu</label>
            <textarea class="form-control" id="gioi_thieu" name="gioi_thieu" rows="3">{{ old('gioi_thieu') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="mo_ta" class="form-label">Mô tả chi tiết</label>
            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="5">{{ old('mo_ta') }}</textarea>
        </div>
        <!-- <div class="mb-3">
                <label for="MoTa" class="form-label">Mô tả chi tiết</label>
                {{-- Đảm bảo có id="MoTa" --}}
                <textarea class="form-control" id="mo_ta" name="mo_ta"
                    rows="10">{{ old('mo_ta', $sanPham->MoTa ?? '') }}</textarea>
            </div> -->
        <div class="mb-3">
            <label for="thuong_hieu" class="form-label">Thương hiệu</label>
            <input type="text" class="form-control" id="thuong_hieu" name="thuong_hieu" value="{{ old('thuong_hieu') }}">
        </div>
        <div class="mb-3">
            <label for="man_hinh" class="form-label">Màn hình</label>
            <input type="text" class="form-control" id="man_hinh" name="man_hinh" value="{{ old('man_hinh') }}">
        </div>
        <div class="mb-3">
            <label for="do_phan_giai" class="form-label">Độ phân giải</label>
            <input type="text" class="form-control" id="do_phan_giai" name="do_phan_giai" value="{{ old('do_phan_giai') }}">
        </div>
        <div class="mb-3">
            <label for="camera" class="form-label">Camera</label>
            <input type="text" class="form-control" id="camera" name="camera" value="{{ old('camera') }}">
        </div>
        <div class="mb-3">
            <label for="cpu" class="form-label">CPU</label>
            <input type="text" class="form-control" id="cpu" name="cpu" value="{{ old('cpu') }}">
        </div>
        <div class="mb-3">
            <label for="pin" class="form-label">Pin</label>
            <input type="text" class="form-control" id="pin" name="pin" value="{{ old('pin') }}">
        </div>
        <div class="mb-3">
            <label for="ngay_phat_hanh" class="form-label">Ngày phát hành</label>
            <input type="date" class="form-control" id="ngay_phat_hanh" name="ngay_phat_hanh"
                value="{{ old('ngay_phat_hanh') }}">
        </div>
        <div class="mb-3">
            <label for="dung_luong" class="form-label">Dung lượng</label>
            <input type="text" class="form-control" id="dung_luong" name="dung_luong" value="{{ old('dung_luong') }}">
        </div>
        <div class="mb-3">
            <label for="kich_thuoc" class="form-label">Kích thước</label>
            <input type="text" class="form-control" id="kich_thuoc" name="kich_thuoc" value="{{ old('kich_thuoc') }}">
        </div>
        <div class="mb-3">
            <label for="trong_luong" class="form-label">Trọng lượng</label>
            <input type="text" class="form-control" id="trong_luong" name="trong_luong" value="{{ old('trong_luong') }}">
        </div>
        <div class="mb-3">
            <label for="so_luong_con" class="form-label">Số lượng còn</label>
            <input type="number" class="form-control" id="so_luong_con" name="so_luong_con"
                value="{{ old('so_luong_con') }}">
        </div>
        <div class="mb-3">
            <label for="loai_san_pham_id" class="form-label">Loại sản phẩm</label>
            <select class="form-select" id="loai_san_pham_id" name="loai_san_pham_id">
                <option selected disabled>-- Chọn loại sản phẩm --</option>
                @foreach ($loaiSanPhams as $loai)

                    <option value="{{ $loai->id }}">{{ $loai->name }}</option>

                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="HinhAnh" class="form-label">Hình ảnh (Có thể chọn nhiều ảnh)</label>
            {{-- Thêm multiple và đổi name thành HinhAnh[] --}}
            <input class="form-control" type="file" id="HinhAnh" name="HinhAnh[]" multiple>
        </div>

        {{-- Thêm input cho hình ảnh nếu cần, dùng name="hinh_anh" --}}
        {{-- <div class="mb-3">
            <label for="hinh_anh" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" id="hinh_anh" name="hinh_anh">
        </div> --}}

        <button type="submit" class="btn btn-primary">Thêm mới</button>
        <a href="{{ route('admin.san_pham.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
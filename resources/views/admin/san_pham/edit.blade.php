@extends('layouts.admin')

@section('content')
    <h1>Cập nhật Sản phẩm</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.san-pham.update', $sanPham) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Quan trọng: Dùng phương thức PUT cho update --}}
        
        <div class="mb-3">
            <label for="Name" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="Name" name="Name" value="{{ old('Name', $sanPham->Name) }}">
        </div>
        <div class="mb-3">
            <label for="Gia" class="form-label">Giá</label>
            <input type="number" class="form-control" id="Gia" name="Gia" value="{{ old('Gia', $sanPham->Gia) }}">
        </div>
        <div class="mb-3">
            <label for="SoLuongCon" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="SoLuongCon" name="SoLuongCon" value="{{ old('SoLuongCon', $sanPham->SoLuongCon) }}">
        </div>
        <div class="mb-3">
            <label for="loai_san_pham_id" class="form-label">Loại sản phẩm</label>
            <select class="form-select" id="loai_san_pham_id" name="loai_san_pham_id">
                @foreach ($loaiSanPhams as $loai)
                    <option value="{{ $loai->id }}" @if($sanPham->loai_san_pham_id == $loai->id) selected @endif>
                        {{ $loai->Name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="MoTa" class="form-label">Mô tả</label>
            <textarea class="form-control" id="MoTa" name="MoTa" rows="3">{{ old('MoTa', $sanPham->MoTa) }}</textarea>
        </div>

        {{-- Thêm các trường khác tương tự ở đây --}}

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.san-pham.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
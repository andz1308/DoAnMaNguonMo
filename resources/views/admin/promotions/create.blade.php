@extends('admin.layouts.app')

@section('title', 'Thêm khuyến mãi mới')
@section('page-title', 'Thêm khuyến mãi mới')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title mb-0">
                <i class="fas fa-plus-circle me-2"></i>Tạo khuyến mãi mới
            </h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-circle me-2"></i>Có lỗi xảy ra:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.khuyen_mai.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag me-1"></i>Tên khuyến mãi <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="VD: BACK TO SCHOOL, MERRY CHRISTMAS"
                            required
                        >
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="gia" class="form-label">
                            <i class="fas fa-percentage me-1"></i>Giá trị giảm (%) <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="number" 
                            class="form-control @error('gia') is-invalid @enderror" 
                            id="gia" 
                            name="gia" 
                            value="{{ old('gia') }}"
                            placeholder="VD: 10, 20, 50"
                            min="0"
                            max="100"
                            step="0.01"
                            required
                        >
                        @error('gia')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ngay_bd" class="form-label">
                            <i class="fas fa-calendar-alt me-1"></i>Ngày bắt đầu
                        </label>
                        <input 
                            type="date" 
                            class="form-control @error('ngay_bd') is-invalid @enderror" 
                            id="ngay_bd" 
                            name="ngay_bd" 
                            value="{{ old('ngay_bd') }}"
                        >
                        @error('ngay_bd')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="ngay_kt" class="form-label">
                            <i class="fas fa-calendar-alt me-1"></i>Ngày kết thúc
                        </label>
                        <input 
                            type="date" 
                            class="form-control @error('ngay_kt') is-invalid @enderror" 
                            id="ngay_kt" 
                            name="ngay_kt" 
                            value="{{ old('ngay_kt') }}"
                        >
                        @error('ngay_kt')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="san_phams" class="form-label">
                        <i class="fas fa-box me-1"></i>Áp dụng cho sản phẩm
                    </label>
                    <select 
                        class="form-select @error('san_phams') is-invalid @enderror" 
                        id="san_phams" 
                        name="san_phams[]" 
                        multiple
                        size="8"
                    >
                        @forelse($sanPhams as $sp)
                            <option value="{{ $sp->id }}" @if(in_array($sp->id, old('san_phams', []))) selected @endif>
                                {{ $sp->name }} ({{ number_format($sp->gia) }}₫)
                            </option>
                        @empty
                            <option disabled>Không có sản phẩm nào</option>
                        @endforelse
                    </select>
                    <small class="text-muted d-block mt-1">
                        <i class="fas fa-info-circle me-1"></i>Giữ Ctrl (hoặc Cmd trên Mac) + Click để chọn nhiều sản phẩm
                    </small>
                    @error('san_phams')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Tạo khuyến mãi
                    </button>
                    <a href="{{ route('admin.khuyen_mai.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 1px solid #d0d0d0;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
@endsection

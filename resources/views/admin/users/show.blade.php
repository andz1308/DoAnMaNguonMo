@extends('admin.layouts.app')

@section('title', 'Chi tiết người dùng')
@section('page-title', 'Chi tiết người dùng')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin người dùng</h4>
            <div>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-1"></i>Chỉnh sửa
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Thông tin chung</strong>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Họ và tên</p>
                            <h5>{{ $user->name }}</h5>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email</p>
                            <h5>{{ $user->email }}</h5>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Số điện thoại</p>
                            <h6>{{ $user->dien_thoai ?? 'Chưa cập nhật' }}</h6>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Địa chỉ</p>
                            <h6>{{ $user->dia_chi ?? 'Chưa cập nhật' }}</h6>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Giới tính</p>
                            @php
                                $genderMap = [
                                    'Nam' => 'Nam',
                                    'Nu' => 'Nữ',
                                    'Khac' => 'Khác',
                                ];
                                $genderLabel = $genderMap[$user->gioi_tinh ?? ''] ?? 'Không xác định';
                            @endphp
                            <span class="badge bg-secondary">{{ $genderLabel }}</span>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Vai trò</p>
                            <span class="badge bg-info">{{ $user->role->name ?? 'Vai trò khác' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Trạng thái hệ thống</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-1">Trạng thái tài khoản</p>
                    @if(($user->trang_thai ?? 1) == 1)
                        <span class="badge bg-success">Hoạt động</span>
                    @else
                        <span class="badge bg-danger">Bị khóa</span>
                    @endif
                    <hr>
                    <p class="text-muted mb-1">Ngày tạo</p>
                    <h6>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'Không xác định' }}</h6>
                    <p class="text-muted mb-1 mt-3">Cập nhật lần cuối</p>
                    <h6>{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'Không xác định' }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


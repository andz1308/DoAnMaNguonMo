@extends('layouts.app')

@section('content')
<style>
    .profile-breadcrumb {
        background: #f5f5f5;
        padding: 8px 12px;
        border-radius: 4px;
        margin-bottom: 15px;
        font-size: 13px;
    }
    .profile-breadcrumb a {
        color: #0088cc;
    }
    .profile-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .profile-card-header {
        background: #f9f9f9;
        border-bottom: 2px solid #0088cc;
        padding: 12px 15px;
        border-radius: 4px 4px 0 0;
    }
    .profile-card-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
        font-weight: 600;
    }
    .profile-card-header h3 i {
        margin-right: 8px;
        color: #0088cc;
    }
    .profile-card-body {
        padding: 15px;
    }
    .profile-info-group {
        margin-bottom: 15px;
    }
    .profile-info-label {
        font-size: 11px;
        color: #999;
        text-transform: uppercase;
        margin-bottom: 3px;
        font-weight: 600;
    }
    .profile-info-value {
        font-size: 14px;
        color: #333;
        font-weight: 600;
        padding: 6px 10px;
        background: #f5f5f5;
        border-radius: 3px;
        border-left: 3px solid #0088cc;
    }
    .profile-info-empty {
        color: #999;
        font-style: italic;
    }
    .profile-divider {
        border-top: 1px solid #ddd;
        margin: 15px 0;
    }
    .profile-actions {
        padding-top: 10px;
    }
    .profile-actions .btn {
        margin-right: 8px;
        margin-bottom: 5px;
    }
    .role-badge-admin {
        background: #b94a48;
        color: white;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
    }
    .role-badge-user {
        background: #468847;
        color: white;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
    }
    .quick-links-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .quick-links-header {
        background: #f9f9f9;
        border-bottom: 1px solid #ddd;
        padding: 10px 15px;
        border-radius: 4px 4px 0 0;
    }
    .quick-links-header h5 {
        margin: 0;
        font-size: 15px;
        color: #333;
        font-weight: 600;
    }
    .quick-links-body {
        padding: 15px;
    }
    .quick-link-btn {
        display: block;
        width: 100%;
        text-align: left;
        padding: 10px 12px;
        margin-bottom: 8px;
        border: 1px solid #ddd;
        border-radius: 3px;
        color: #0088cc;
        text-decoration: none;
        transition: all 0.2s;
        background: #fff;
    }
    .quick-link-btn:hover {
        background: #0088cc;
        color: white;
        border-color: #0088cc;
        text-decoration: none;
    }
    .quick-link-btn i {
        margin-right: 8px;
        width: 20px;
        text-align: center;
    }
    .alert-success-custom {
        background: #dff0d8;
        border: 1px solid #d6e9c6;
        color: #468847;
        padding: 10px 12px;
        border-radius: 3px;
        margin-bottom: 15px;
        font-size: 13px;
    }
    .profile-section {
        margin-bottom: 20px;
    }
    .profile-row {
        margin-bottom: 12px;
    }
</style>

<!-- Breadcrumb -->
<div class="profile-breadcrumb">
    <a href="{{ route('home') }}">Trang chủ</a>
    <span style="color: #999; margin: 0 5px;">/</span>
    <span style="color: #333; font-weight: 600;">Thông tin cá nhân</span>
</div>

<div class="row">
    <div class="span9">
        @if ($message = Session::get('success'))
            <div class="alert-success-custom">
                <button type="button" class="close" data-dismiss="alert" style="float: right; opacity: 0.5;">×</button>
                <i class="icon-ok"></i> <strong>Thành công!</strong> {{ $message }}
            </div>
        @endif

        <!-- Card thông tin người dùng -->
        <div class="profile-card">
            <div class="profile-card-header">
                <h3><i class="icon-user"></i> Thông tin cá nhân</h3>
            </div>
            <div class="profile-card-body">
                <!-- Thông tin cơ bản -->
                <div class="profile-section">
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="profile-info-group">
                                <div class="profile-info-label">
                                    <i class="icon-user"></i> Họ và tên
                                </div>
                                <div class="profile-info-value">
                                    {{ $user->name }}
                                </div>
                            </div>
                            
                            <div class="profile-info-group">
                                <div class="profile-info-label">
                                    <i class="icon-envelope"></i> Email
                                </div>
                                <div class="profile-info-value">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="span6">
                            <div class="profile-info-group">
                                <div class="profile-info-label">
                                    <i class="icon-phone"></i> Số điện thoại
                                </div>
                                <div class="profile-info-value {{ !$user->dien_thoai ? 'profile-info-empty' : '' }}">
                                    {{ $user->dien_thoai ?? 'Chưa cập nhật' }}
                                </div>
                            </div>
                            
                            <div class="profile-info-group">
                                <div class="profile-info-label">
                                    <i class="icon-user"></i> Giới tính
                                </div>
                                <div class="profile-info-value {{ !$user->gioi_tinh ? 'profile-info-empty' : '' }}">
                                    {{ $user->gioi_tinh ?? 'Chưa cập nhật' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-section">
                    <div class="profile-info-group">
                        <div class="profile-info-label">
                            <i class="icon-home"></i> Địa chỉ
                        </div>
                        <div class="profile-info-value {{ !$user->dia_chi ? 'profile-info-empty' : '' }}">
                            {{ $user->dia_chi ?? 'Chưa cập nhật' }}
                        </div>
                    </div>
                </div>

                <!-- Vai trò -->
                <!-- <div class="profile-section">
                    <div class="profile-info-group">
                        <div class="profile-info-label">
                            <i class="icon-star"></i> Vai trò
                        </div>
                        <div style="padding: 6px 0;">
                            @if($user->role_id == 1)
                                <span class="role-badge-admin">
                                    <i class="icon-star icon-white"></i> Quản trị viên
                                </span>
                            @else
                                <span class="role-badge-user">
                                    <i class="icon-user icon-white"></i> Người dùng
                                </span>
                            @endif
                        </div>
                    </div>
                </div> -->

                <div class="profile-divider"></div>

                <!-- Các nút hành động -->
                <div class="profile-actions">
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-warning">
                        <i class="icon-edit icon-white"></i> Chỉnh sửa thông tin
                    </a>
                    <a href="{{ route('home') }}" class="btn">
                        <i class="icon-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>

        <!-- Các liên kết nhanh -->
        <div class="quick-links-card">
            <div class="quick-links-header">
                <h5><i class="icon-list-alt"></i> Liên kết nhanh</h5>
            </div>
            <div class="quick-links-body">
                <div class="row-fluid">
                    <div class="span6">
                        <a href="#" class="quick-link-btn">
                            <i class="icon-shopping-cart"></i> Đơn hàng của tôi
                        </a>
                        <a href="#" class="quick-link-btn">
                            <i class="icon-star"></i> Đánh giá sản phẩm
                        </a>
                    </div>
                    <div class="span6">
                        <a href="#" class="quick-link-btn">
                            <i class="icon-heart"></i> Yêu thích
                        </a>
                        <a href="#" class="quick-link-btn">
                            <i class="icon-question-sign"></i> Hỗ trợ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
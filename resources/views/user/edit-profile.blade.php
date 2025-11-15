@extends('layouts.app')

@section('content')
<style>
    .edit-breadcrumb {
        background: #f5f5f5;
        padding: 8px 12px;
        border-radius: 4px;
        margin-bottom: 15px;
        font-size: 13px;
    }
    .edit-breadcrumb a {
        color: #0088cc;
    }
    .edit-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .edit-card-header {
        background: #f9f9f9;
        border-bottom: 2px solid #0088cc;
        padding: 12px 15px;
        border-radius: 4px 4px 0 0;
    }
    .edit-card-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
        font-weight: 600;
    }
    .edit-card-header h3 i {
        margin-right: 8px;
        color: #0088cc;
    }
    .edit-card-body {
        padding: 15px;
    }
    .form-group-edit {
        margin-bottom: 15px;
    }
    .form-label-edit {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 13px;
        color: #333;
    }
    .form-label-edit i {
        margin-right: 5px;
        color: #0088cc;
    }
    .form-label-edit .required {
        color: #b94a48;
    }
    .form-control-edit {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 13px;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .form-control-edit:focus {
        border-color: #0088cc;
        outline: none;
        box-shadow: 0 0 5px rgba(0,136,204,0.3);
    }
    .form-control-edit.error {
        border-color: #b94a48;
    }
    .form-select-edit {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 13px;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }
    .form-select-edit:focus {
        border-color: #0088cc;
        outline: none;
        box-shadow: 0 0 5px rgba(0,136,204,0.3);
    }
    .error-text {
        color: #b94a48;
        font-size: 12px;
        margin-top: 3px;
        display: block;
    }
    .alert-error-edit {
        background: #f2dede;
        border: 1px solid #ebccd1;
        color: #a94442;
        padding: 12px 15px;
        border-radius: 3px;
        margin-bottom: 15px;
    }
    .alert-error-edit h5 {
        margin: 0 0 8px 0;
        font-size: 14px;
        font-weight: 600;
    }
    .alert-error-edit ul {
        margin: 0;
        padding-left: 20px;
    }
    .alert-error-edit li {
        font-size: 13px;
    }
    .alert-info-edit {
        background: #d9edf7;
        border: 1px solid #bce8f1;
        color: #31708f;
        padding: 10px 12px;
        border-radius: 3px;
        margin-bottom: 15px;
        font-size: 13px;
    }
    .form-divider {
        border-top: 1px solid #ddd;
        margin: 15px 0;
    }
    .form-actions-edit {
        padding-top: 10px;
    }
    .form-actions-edit .btn {
        margin-right: 8px;
    }
    .form-row {
        margin-left: -10px;
        margin-right: -10px;
    }
    .form-col-half {
        float: left;
        width: 50%;
        padding-left: 10px;
        padding-right: 10px;
        box-sizing: border-box;
    }
    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<!-- Breadcrumb -->
<div class="edit-breadcrumb">
    <a href="{{ route('home') }}">Trang chủ</a>
    <span style="color: #999; margin: 0 5px;">/</span>
    <a href="{{ route('user.profile.show') }}">Thông tin cá nhân</a>
    <span style="color: #999; margin: 0 5px;">/</span>
    <span style="color: #333; font-weight: 600;">Chỉnh sửa</span>
</div>

<div class="row">
    <div class="span9">
        @if ($errors->any())
            <div class="alert-error-edit">
                <button type="button" class="close" data-dismiss="alert" style="float: right; opacity: 0.5;">×</button>
                <h5><i class="icon-exclamation-sign"></i> Có lỗi xảy ra</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="edit-card">
            <div class="edit-card-header">
                <h3><i class="icon-edit"></i> Chỉnh sửa thông tin cá nhân</h3>
            </div>
            <div class="edit-card-body">
                <form action="{{ route('user.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Họ và tên -->
                    <div class="form-group-edit">
                        <label for="name" class="form-label-edit">
                            <i class="icon-user"></i>Họ và tên <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control-edit @error('name') error @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $user->name) }}"
                            placeholder="Nhập họ và tên"
                            required
                        >
                        @error('name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group-edit">
                        <label for="email" class="form-label-edit">
                            <i class="icon-envelope"></i>Email <span class="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            class="form-control-edit @error('email') error @enderror" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}"
                            placeholder="Nhập email"
                            required
                        >
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Số điện thoại & Giới tính -->
                    <div class="form-row clearfix">
                        <div class="form-col-half">
                            <div class="form-group-edit">
                                <label for="dien_thoai" class="form-label-edit">
                                    <i class="icon-phone"></i>Số điện thoại
                                </label>
                                <input 
                                    type="tel" 
                                    class="form-control-edit @error('dien_thoai') error @enderror" 
                                    id="dien_thoai" 
                                    name="dien_thoai" 
                                    value="{{ old('dien_thoai', $user->dien_thoai) }}"
                                    placeholder="Nhập số điện thoại"
                                >
                                @error('dien_thoai')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-col-half">
                            <div class="form-group-edit">
                                <label for="gioi_tinh" class="form-label-edit">
                                    <i class="icon-user"></i>Giới tính
                                </label>
                                <select class="form-select-edit @error('gioi_tinh') error @enderror" id="gioi_tinh" name="gioi_tinh">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="Nam" @if(old('gioi_tinh', $user->gioi_tinh) === 'Nam') selected @endif>Nam</option>
                                    <option value="Nữ" @if(old('gioi_tinh', $user->gioi_tinh) === 'Nữ') selected @endif>Nữ</option>
                                    <option value="Khác" @if(old('gioi_tinh', $user->gioi_tinh) === 'Khác') selected @endif>Khác</option>
                                </select>
                                @error('gioi_tinh')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Địa chỉ -->
                    <div class="form-group-edit">
                        <label for="dia_chi" class="form-label-edit">
                            <i class="icon-home"></i>Địa chỉ
                        </label>
                        <input 
                            type="text" 
                            class="form-control-edit @error('dia_chi') error @enderror" 
                            id="dia_chi" 
                            name="dia_chi" 
                            value="{{ old('dia_chi', $user->dia_chi) }}"
                            placeholder="Nhập địa chỉ"
                        >
                        @error('dia_chi')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-divider"></div>

                    <!-- Mật khẩu mới (tùy chọn) -->
                    <div class="alert-info-edit">
                        <i class="icon-info-sign"></i>
                        <strong>Đổi mật khẩu:</strong> Để giữ nguyên mật khẩu hiện tại, để trống 2 trường dưới đây.
                    </div>

                    <div class="form-row clearfix">
                        <div class="form-col-half">
                            <div class="form-group-edit">
                                <label for="password" class="form-label-edit">
                                    <i class="icon-lock"></i>Mật khẩu mới
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control-edit @error('password') error @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Nhập mật khẩu mới"
                                >
                                @error('password')
                                    <span class="error-text">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-col-half">
                            <div class="form-group-edit">
                                <label for="password_confirmation" class="form-label-edit">
                                    <i class="icon-lock"></i>Xác nhận mật khẩu
                                </label>
                                <input 
                                    type="password" 
                                    class="form-control-edit" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="Xác nhận mật khẩu"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="form-divider"></div>

                    <!-- Các nút hành động -->
                    <div class="form-actions-edit">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-ok icon-white"></i> Lưu thay đổi
                        </button>
                        <a href="{{ route('user.profile.show') }}" class="btn">
                            <i class="icon-remove"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
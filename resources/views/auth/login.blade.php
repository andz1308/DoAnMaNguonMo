<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - PhoneStore</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    {{-- Copy CSS từ file cũ vào đây --}}
    <style>
        :root {
            --primary-color: #00a0e3;
            --secondary-color: #0056b3;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-container {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 30px;
            text-align: center;
            color: white;
        }
        .auth-logo { font-size: 3rem; margin-bottom: 10px; }
        .auth-header h2 { font-size: 1.8rem; font-weight: bold; margin: 0; }
        .auth-header p { margin: 10px 0 0 0; opacity: 0.9; font-size: 0.95rem; }
        .auth-body { padding: 40px; }
        .form-group { margin-bottom: 25px; }
        .form-label {
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }
        .form-label span { color: #dc3545; }
        .input-group-custom { position: relative; }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.1rem;
        }
        .form-control {
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 160, 227, 0.15);
            outline: none;
        }
        .form-control.is-invalid { border-color: #dc3545; }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 5px;
            transition: color 0.3s ease;
        }
        .password-toggle:hover { color: var(--primary-color); }
        .forgot-password {
            text-align: right;
            margin-top: -15px;
            margin-bottom: 25px;
        }
        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .forgot-password a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        .btn-auth {
            width: 100%;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }
        .btn-primary-auth {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 15px rgba(0, 160, 227, 0.3);
        }
        .btn-primary-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 160, 227, 0.4);
        }
        .btn-primary-auth:active { transform: translateY(0); }
        .auth-footer {
            text-align: center;
            padding: 20px;
            background: var(--light-bg);
            font-size: 0.95rem;
            color: #666;
            margin-top: 20px; /* Thêm khoảng cách */
        }
        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .auth-footer a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: .875em;
            color: #dc3545;
        }
        .back-home {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }
        .back-home a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .back-home a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-5px);
        }
        @media (max-width: 576px) {
            .auth-body { padding: 30px 25px; }
            .auth-header h2 { font-size: 1.5rem; }
            .back-home {
                position: static;
                text-align: center;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="back-home">
        <a href="{{ url('/') }}">
            <i class="fas fa-arrow-left"></i>
            Về trang chủ
        </a>
    </div>

    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <h2>PhoneStore</h2>
            <p>Đăng nhập tài khoản</p> {{-- Sửa text --}}
        </div>

        <div class="auth-body">
            
            {{-- Khối hiển thị lỗi chung (chỉ hiển thị lỗi không thuộc về field nào cụ thể) --}}
            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li><small>{{ $error }}</small></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email <span>*</span></label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope input-icon"></i>
                        {{-- Giữ lại giá trị cũ và hiển thị lỗi --}}
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="login-email" name="email"
                               placeholder="Nhập Email" value="{{ old('email') }}" required autofocus> {{-- Thêm autofocus --}}
                    </div>
                     {{-- Hiển thị lỗi ngay dưới input --}}
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu <span>*</span></label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="login-password" name="password"
                               placeholder="Nhập mật khẩu" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                            <i class="fas fa-eye" id="login-password-icon"></i>
                        </button>
                    </div>
                     {{-- Hiển thị lỗi ngay dưới input --}}
                     @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                     @enderror
                </div>

                <div class="forgot-password">
                    <a href="#">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn-auth btn-primary-auth">
                    <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                </button>
            </form>

             <div class="auth-footer">
                 {{-- Sửa link footer trỏ sang trang đăng ký --}}
                <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Chỉ giữ lại hàm togglePassword
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
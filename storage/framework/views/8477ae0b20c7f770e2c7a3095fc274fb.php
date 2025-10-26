<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - PhoneStore</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        .form-check { margin-bottom: 20px; }
        .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 0.15rem;
            cursor: pointer;
        }
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .form-check-label {
            margin-left: 8px;
            color: #666;
            cursor: pointer;
            font-size: 0.95rem;
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
             margin-top: 20px; 
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
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
            display: none;
        }
        .password-strength.show { display: block; }
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        .password-strength-bar.weak { width: 33%; background: #dc3545; }
        .password-strength-bar.medium { width: 66%; background: #ffc107; }
        .password-strength-bar.strong { width: 100%; background: #28a745; }
        .password-hint { font-size: 0.85rem; color: #999; margin-top: 5px; }
        .error-message { /* Dùng cho JS check password match */
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }
        .error-message.show { display: block; }
         .invalid-feedback { /* Dùng cho lỗi từ Laravel */
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
        <a href="<?php echo e(url('/')); ?>">
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
             <p>Đăng ký tài khoản mới</p> 
        </div>

        <div class="auth-body">

             
             <?php if($errors->any()): ?>
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><small><?php echo e($error); ?></small></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label">Họ và tên <span>*</span></label>
                    <div class="input-group-custom">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="register-name" name="name"
                               placeholder="Nhập họ và tên" value="<?php echo e(old('name')); ?>" required>
                    </div>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span>*</span></label>
                    <div class="input-group-custom">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="register-email" name="email"
                               placeholder="Nhập Email (dùng để đăng nhập)" value="<?php echo e(old('email')); ?>" required>
                    </div>
                    <small class="password-hint">Ví dụ: example@gmail.com</small>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Mật khẩu <span>*</span></label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="register-password" name="password"
                               placeholder="Nhập mật khẩu" required oninput="checkPasswordStrength(this.value)">
                        <button type="button" class="password-toggle" onclick="togglePassword('register-password')">
                            <i class="fas fa-eye" id="register-password-icon"></i>
                        </button>
                    </div>
                    <div class="password-strength" id="password-strength">
                        <div class="password-strength-bar" id="password-strength-bar"></div>
                    </div>
                    <small class="password-hint">Mật khẩu tối thiểu 6 ký tự.</small>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Nhập lại mật khẩu <span>*</span></label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" {-- Không cần is-invalid ở đây vì Laravel check 'confirmed' --}}{
                               id="register-confirm-password" name="password_confirmation"
                               placeholder="Nhập lại mật khẩu" required oninput="checkPasswordMatch()">
                        <button type="button" class="password-toggle" onclick="togglePassword('register-confirm-password')">
                            <i class="fas fa-eye" id="register-confirm-password-icon"></i>
                        </button>
                    </div>
                    <small class="error-message" id="password-match-error">Mật khẩu không khớp</small>
                </div>

                 <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agree-terms">
                    <label class="form-check-label" for="agree-terms">
                        Tôi đồng ý với <a href="#" style="color: var(--primary-color);">điều khoản sử dụng</a>
                    </label>
                </div>

                <button type="submit" class="btn-auth btn-primary-auth">
                    <i class="fas fa-user-plus me-2"></i>Đăng ký
                </button>
            </form>

            <div class="auth-footer">
                
                <p>Đã có tài khoản? <a href="<?php echo e(route('login')); ?>">Đăng nhập ngay</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
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

        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthContainer = document.getElementById('password-strength');
            if (password.length === 0) {
                strengthContainer.classList.remove('show');
                return;
            }
            strengthContainer.classList.add('show');
            let strength = 0;
            if (password.length >= 6) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            if (strength <= 2) {
                strengthBar.classList.add('weak');
            } else if (strength <= 3) {
                strengthBar.classList.add('medium');
            } else {
                strengthBar.classList.add('strong');
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('register-confirm-password').value;
            const errorMessage = document.getElementById('password-match-error');
            if (confirmPassword.length > 0 && password !== confirmPassword) {
                errorMessage.classList.add('show');
            } else {
                errorMessage.classList.remove('show');
            }
        }
    </script>
</body>
</html><?php /**PATH D:\HOCTAP\Nam_4_1\MaNguonMo\DoAn\DoAnMaNguonMo\resources\views/auth/register.blade.php ENDPATH**/ ?>
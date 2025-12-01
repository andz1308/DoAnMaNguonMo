<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'dien_thoai' => 'required|numeric|digits_between:9,11|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'agree_terms' => 'required|accepted',
        ], [
            'agree_terms.required' => 'Bạn phải đồng ý với điều khoản sử dụng.',
            'agree_terms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng.',
            'dien_thoai.required' => 'Vui lòng nhập số điện thoại.',
            'dien_thoai.numeric' => 'Số điện thoại phải là định dạng số.',
            'dien_thoai.digits_between' => 'Số điện thoại phải có từ 9 đến 11 chữ số.',
            'dien_thoai.unique' => 'Số điện thoại này đã được đăng ký tài khoản khác.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.', 
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dien_thoai' => $request->dien_thoai,
            'password' => Hash::make($request->password), 
            'role_id' => 2, 
            'dia_chi' => '', 
            'gioi_tinh' => 'Khác', 
            'trang_thai' => 1, // 1: Hoạt động
        ]);

        // Tự động đăng nhập sau khi đăng ký
        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký thành công!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Hỗ trợ đăng nhập bằng Email HOẶC SĐT, Tự động so khớp Hash
    public function login(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginId = $request->login_id;
        $password = $request->password;

        // 2. Xác định xem người dùng nhập Email hay SĐT
        $isEmail = filter_var($loginId, FILTER_VALIDATE_EMAIL);
        $fieldType = $isEmail ? 'email' : 'dien_thoai';

        // 2.1. Tìm user trong DB để check trạng thái trước
        $userCheck = User::where($fieldType, $loginId)->first();

        if ($userCheck) {
            // Nếu user tồn tại nhưng trang_thai là 0 (Vô hiệu hóa)
            if ($userCheck->trang_thai == 0) {
                return back()->withErrors([
                    'login_id' => 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ Admin.',
                ])->onlyInput('login_id');
            }
        }

        // 3. Tạo mảng thông tin đăng nhập (Credentials)
        $credentials = [
            $fieldType => $loginId,
            'password' => $password
        ];

        // 4. Dùng Auth::attempt để đăng nhập
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            $user = Auth::user(); 

            // 5. Chuyển hướng theo role
            if ($user->role_id == 1) { // Admin
                return redirect()->intended('/admin');
            } else { 
                return redirect()->intended('/');
            }
        }

        // 6. Đăng nhập thất bại (Sai pass hoặc không tìm thấy user)
        return back()->withErrors([
            'login_id' => 'Thông tin đăng nhập hoặc mật khẩu không chính xác.',
        ])->onlyInput('login_id');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Cần để mã hóa
use Illuminate\Support\Facades\Auth; // Cần để đăng nhập
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
            'dien_thoai' => 'nullable|numeric|digits_between:9,11',
            'password' => 'required|string|min:6|confirmed',
            'agree_terms' => 'required|accepted',
        ], [
            'agree_terms.required' => 'Bạn phải đồng ý với điều khoản sử dụng.',
            'agree_terms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng.',
            'dien_thoai.numeric' => 'Số điện thoại phải là định dạng số.',
            'dien_thoai.digits_between' => 'Số điện thoại phải có từ 9 đến 11 chữ số.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);

        // 2. Tạo User mới (CÓ BĂM MẬT KHẨU)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dien_thoai' => $request->dien_thoai,
            // [QUAN TRỌNG] Dùng Hash::make để mã hóa mật khẩu
            'password' => Hash::make($request->password), 
            'role_id' => 2, // Mặc định là User thường
        ]);

        // 3. Tự động đăng nhập sau khi đăng ký
        Auth::login($user);

        // 4. Chuyển hướng
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

        // 3. Tạo mảng thông tin đăng nhập (Credentials)
        $credentials = [
            $fieldType => $loginId, // key là 'email' hoặc 'dien_thoai'
            'password' => $password // Laravel sẽ tự lấy cái này, băm ra và so sánh với DB
        ];

        // 4. Dùng Auth::attempt để đăng nhập
        // Hàm này tự động kiểm tra user có tồn tại không VÀ mật khẩu hash có khớp không
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            $user = Auth::user(); // Lấy thông tin user đã login

            // 5. Chuyển hướng theo role
            if ($user->role_id == 1) { // Admin
                return redirect()->intended('/admin');
            } else { 
                return redirect()->intended('/');
            }
        }

        // 6. Đăng nhập thất bại
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
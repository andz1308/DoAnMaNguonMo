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
        // 1. Validate (kiểm tra) dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Kiểm tra email không trùng
            'password' => 'required|string|min:6|confirmed', // 'confirmed' (phải có 'password_confirmation' giống hệt)
        ]);

        // 2. Tạo User mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Mã hóa password
            'role_id' => 2, // Gán cứng Role NguoiDung (ID=2)
        ]);

        // 3. Tự động đăng nhập
        Auth::login($user);

        // 4. Chuyển hướng về trang chủ
        return redirect('/');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Tìm user bằng email
        $user = User::where('email', $request->email)->first();

        // 3. Kiểm tra user tồn tại VÀ mật khẩu khớp (so sánh chữ thường)
        if ($user && $user->password === $request->password) { // So sánh trực tiếp!

            // 4. Đăng nhập thủ công
            Auth::login($user); // Vẫn dùng Auth::login để tạo session

            $request->session()->regenerate();

            // 5. Chuyển hướng theo role
            if ($user->role_id == 1) { // Admin
                return redirect()->intended('/admin/dashboard'); // Sửa lại URL admin nếu cần
            } else { 
                return redirect()->intended('/');
            }
        }

        // 6. Sai thông tin
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout(); // Xóa session user

        $request->session()->invalidate(); // Hủy session
        $request->session()->regenerateToken(); // Tạo lại token mới

        return redirect('/'); // Về trang chủ
    }
}
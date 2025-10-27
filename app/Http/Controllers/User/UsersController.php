<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; 

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
            // [FIX REGRESS] Đảm bảo email phải đúng định dạng email
            'email' => 'required|string|email|max:255|unique:users', 
            
            // Thêm validation cho Số điện thoại: Tùy chọn, là số, dài từ 9-11 chữ số
            'dien_thoai' => 'nullable|numeric|digits_between:9,11', 
            
            // [FIX LỖI LOGIC] Độ dài mật khẩu tối thiểu 6 ký tự
            'password' => 'required|string|min:6|confirmed', 
            
            // [FIX LỖI] Yêu cầu đồng ý điều khoản
            'agree_terms' => 'required|accepted', 
        ], [
            // Custom message cho agree_terms
            'agree_terms.required' => 'Bạn phải đồng ý với điều khoản sử dụng.',
            'agree_terms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng.',
            
            // Custom messages cho dien_thoai
            'dien_thoai.numeric' => 'Số điện thoại phải là định dạng số.',
            'dien_thoai.digits_between' => 'Số điện thoại phải có từ 9 đến 11 chữ số.',
        ]);

        // 2. Tạo User mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'dien_thoai' => $request->dien_thoai, // Thêm số điện thoại
            // [YÊU CẦU ĐẶC BIỆT] LƯU MẬT KHẨU KHÔNG BĂM
            'password' => $request->password, // Lưu mật khẩu PLAIN TEXT
            'role_id' => 2,
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

    // Hỗ trợ đăng nhập bằng Email HOẶC SĐT, dùng mật khẩu KHÔNG BĂM
    public function login(Request $request)
    {
        // 1. Validate input - Đổi 'email' thành 'login_id' chung
        $request->validate([
            'login_id' => 'required|string', 
            'password' => 'required|string',
        ]);

        $loginId = $request->login_id;
        $password = $request->password;

        // Xác định trường tìm kiếm (Email hay SĐT)
        $isEmail = filter_var($loginId, FILTER_VALIDATE_EMAIL);
        $fieldType = $isEmail ? 'email' : 'dien_thoai';

        // 2. Tìm user bằng Email HOẶC Số điện thoại
        $user = User::where($fieldType, $loginId)->first();

        // 3. Kiểm tra user tồn tại VÀ mật khẩu khớp (So sánh trực tiếp password PLAIN TEXT)
        if ($user && $user->password === $password) { 

            // 4. Đăng nhập thủ công
            Auth::login($user); 
            $request->session()->regenerate();

            // 5. Chuyển hướng theo role
            if ($user->role_id == 1) { // Admin
                return redirect()->intended('/admin/dashboard');
            } else { 
                return redirect()->intended('/');
            }
        }

        // 6. Sai thông tin
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
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    /**
     * Hiển thị thông tin hồ sơ người dùng
     */
    public function show()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }

        return view('user.profile', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin người dùng
     */
    public function edit()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }

        return view('user.edit-profile', compact('user'));
    }

    /**
     * Cập nhật thông tin người dùng
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập');
        }

        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'dien_thoai' => 'nullable|numeric|digits_between:9,11',
            'dia_chi' => 'nullable|string|max:255',
            'gioi_tinh' => 'nullable|in:Nam,Nữ,Khác',
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập tên đầy đủ',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',
            'dien_thoai.numeric' => 'Số điện thoại phải là định dạng số',
            'dien_thoai.digits_between' => 'Số điện thoại phải có từ 9 đến 11 chữ số',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        // Cập nhật thông tin
        $user->name = $request->name;
        $user->email = $request->email;
        $user->dien_thoai = $request->dien_thoai;
        $user->dia_chi = $request->dia_chi;
        $user->gioi_tinh = $request->gioi_tinh;

        // Cập nhật mật khẩu nếu có
        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        return redirect()->route('user.profile.show')->with('success', 'Cập nhật thông tin thành công');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập quyền Admin.');
        }

        // 2. Kiểm tra có phải Admin không
        // Giả sử role_id = 1 là Admin (bạn xem lại bảng roles của mình nhé)
        if (Auth::user()->role_id == 1) { 
            return $next($request); // Cho qua
        }

        // 3. Nếu không phải Admin -> Đuổi về trang chủ
        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập trang quản trị!');
    }
}

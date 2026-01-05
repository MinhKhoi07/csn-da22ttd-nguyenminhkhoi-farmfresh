<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Kiểm tra xem đã đăng nhập chưa?
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Kiểm tra xem có phải là Admin (is_admin = 1) không?
        if (Auth::user()->is_admin == 1) {
            // Đúng là Admin -> Cho qua
            return $next($request);
        }

        // 3. Nếu không phải Admin -> Chặn lại và báo lỗi 403 (Cấm truy cập)
        abort(403, 'Bạn không có quyền truy cập trang quản trị!');
    }
}
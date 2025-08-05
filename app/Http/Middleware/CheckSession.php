<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu session đã hết hạn
        if (Session::has('_token') && !Session::token()) {
            Session::regenerate();
        }

        // Đảm bảo CSRF token luôn có sẵn
        if (!$request->session()->has('_token')) {
            $request->session()->regenerateToken();
        }

        return $next($request);
    }
} 
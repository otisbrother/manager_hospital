<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPatientSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra session bệnh nhân
        if (!session('patient_id')) {
            return redirect()->route('patient.login')->with('error', 'Vui lòng đăng nhập để truy cập.');
        }

        return $next($request);
    }
} 
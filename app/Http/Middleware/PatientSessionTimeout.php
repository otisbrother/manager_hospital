<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PatientSessionTimeout
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
        // Kiểm tra nếu có session patient_id và session ID duy nhất
        if (Session::has('patient_id') && Session::has('patient_session_id')) {
            $lastActivity = Session::get('patient_last_activity');
            $timeout = 10 * 60; // 10 phút = 600 giây
            
            // Nếu chưa có last_activity hoặc đã quá 10 phút
            if (!$lastActivity || (time() - $lastActivity) > $timeout) {
                // Xóa toàn bộ session
                Session::flush();
                Session::save();
                
                return redirect()->route('patient.login')
                    ->with('error', 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
            }
            
            // Cập nhật thời gian hoạt động cuối
            Session::put('patient_last_activity', time());
        }
        
        return $next($request);
    }
} 
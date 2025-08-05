<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Patient;

class PatientSessionManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu có session patient_id
        if (Session::has('patient_id')) {
            $patientId = Session::get('patient_id');
            $sessionId = Session::get('patient_session_id');
            
            // Kiểm tra cookie riêng của bệnh nhân này
            $cookieName = 'patient_session_' . $patientId;
            $cookieValue = $request->cookie($cookieName);
            
            // Nếu cookie không khớp với session, xóa session
            if ($cookieValue !== $sessionId) {
                Session::flush();
                return redirect()->route('patient.login')->with('error', 'Phiên đăng nhập không hợp lệ. Vui lòng đăng nhập lại.');
            }
            
            // Kiểm tra timeout
            $lastActivity = Session::get('patient_last_activity');
            $timeout = 10 * 60; // 10 phút
            
            if (!$lastActivity || (time() - $lastActivity) > $timeout) {
                // Xóa session và cookie
                Session::flush();
                $response = redirect()->route('patient.login')->with('error', 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
                $response->withCookie($cookieName, null, -1); // Xóa cookie
                return $response;
            }
            
            // Cập nhật thời gian hoạt động cuối
            Session::put('patient_last_activity', time());
        }
        
        return $next($request);
    }
} 
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\HealthInsurance;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidateInsuranceData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu có patient_id trong request
        if ($request->has('patient_id') || $request->route('patient')) {
            $patientId = $request->patient_id ?? $request->route('patient');
            
            // Lấy thông tin bệnh nhân
            $patient = Patient::find($patientId);
            
            if ($patient && $patient->insurance_id) {
                // Kiểm tra xem insurance_id có tồn tại trong bảng health_insurance không
                $healthInsurance = HealthInsurance::find($patient->insurance_id);
                
                if (!$healthInsurance) {
                    // Nếu không tồn tại, log lỗi và có thể thông báo
                    Log::warning("Bệnh nhân {$patient->id} có insurance_id không hợp lệ: {$patient->insurance_id}");
                    
                    // Có thể trả về lỗi hoặc tiếp tục với insurance_id = null
                    // return response()->json(['error' => 'Insurance ID không hợp lệ'], 400);
                }
            }
        }

        return $next($request);
    }
} 
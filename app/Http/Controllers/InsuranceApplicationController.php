<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InsuranceApplication;
use App\Models\Patient;
use App\Models\HealthInsurance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InsuranceApplicationController extends Controller
{
    // Test method để debug
    public function test()
    {
        return response()->json([
            'message' => 'Controller is working',
            'session_patient_id' => session('patient_id'),
            'session_data' => session()->all()
        ]);
    }

    // Bệnh nhân đăng ký hồ sơ BHYT
    public function create()
    {
        try {
            $patient = $this->getAuthenticatedPatient();
            
            // Kiểm tra xem đã có hồ sơ đang chờ duyệt chưa
            $pendingApplication = $patient->insuranceApplications()
                ->where('status', 'pending')
                ->first();
                
            if ($pendingApplication) {
                return redirect()->route('patients.home')
                    ->with('warning', 'Bạn đã có hồ sơ BHYT đang chờ duyệt. Vui lòng chờ admin xử lý.');
            }

            return view('patients.insurance.create', compact('patient'));
        } catch (\Exception $e) {
            return redirect()->route('patient.login')->with('error', $e->getMessage());
        }
    }

    // Lưu hồ sơ đăng ký BHYT
    public function store(Request $request)
    {
        try {
            $patient = $this->getAuthenticatedPatient();
            
            // Debug: Log request data
            Log::info('Insurance application request data:', $request->all());
            Log::info('Patient ID:', ['patient_id' => $patient->id]);
            
            $request->validate([
                'insurance_id' => 'nullable|string|max:20', // Tăng độ dài tối đa cho mã BHYT tự do
                'support_level' => 'required|in:80,95,100',
                'proof_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Mã BHYT là tự do, không cần kiểm tra tồn tại trong hệ thống
            // Bệnh nhân có thể nhập bất kỳ mã nào họ có

            // Xử lý upload ảnh chứng minh
            $proofImages = [];
            if ($request->hasFile('proof_images')) {
                Log::info('Uploading proof images for patient: ' . $patient->id);
                Log::info('Number of files: ' . count($request->file('proof_images')));
                
                foreach ($request->file('proof_images') as $index => $image) {
                    Log::info('Processing image ' . $index . ': ' . $image->getClientOriginalName());
                    
                    try {
                        $path = $image->store('insurance_proofs', 'public');
                        $proofImages[] = $path;
                        Log::info('Image saved to: ' . $path);
                    } catch (\Exception $e) {
                        Log::error('Failed to save image: ' . $e->getMessage());
                        return back()->withErrors(['proof_images' => 'Không thể lưu ảnh: ' . $e->getMessage()]);
                    }
                }
                
                Log::info('Final proof images array: ' . json_encode($proofImages));
            } else {
                Log::info('No proof images uploaded for patient: ' . $patient->id);
            }

            // Kiểm tra xem có cần ảnh chứng minh không
            if (in_array($request->support_level, ['95', '100']) && empty($proofImages)) {
                return back()->withErrors(['proof_images' => 'Mức hỗ trợ ' . $request->support_level . '% yêu cầu phải có ảnh chứng minh.']);
            }

            // Tạo hồ sơ đăng ký
            $application = InsuranceApplication::create([
                'patient_id' => $patient->id,
                'insurance_id' => $request->insurance_id,
                'support_level' => $request->support_level,
                'status' => 'pending',
                'proof_images' => $proofImages,
                'admin_notified' => false, // Đảm bảo thông báo admin được reset
            ]);

            Log::info('Insurance application created: ' . $application->id . ' with proof images: ' . json_encode($proofImages));

            return redirect()->route('patients.home')
                ->with('success', 'Đã gửi hồ sơ đăng ký BHYT thành công! Vui lòng chờ admin duyệt.');
        } catch (\Exception $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('patients.home')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Admin: Xem danh sách hồ sơ chờ duyệt
    public function adminIndex()
    {
        $applications = InsuranceApplication::with(['patient', 'healthInsurance'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.insurance_applications.index', compact('applications'));
    }

    // Admin: Xem chi tiết hồ sơ
    public function adminShow($id)
    {
        $application = InsuranceApplication::with(['patient', 'healthInsurance', 'approvedBy'])
            ->findOrFail($id);

        return view('admin.insurance_applications.show', compact('application'));
    }

    // Admin: Duyệt hồ sơ
    public function adminApprove(Request $request, $id)
    {
        $application = InsuranceApplication::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $application->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Cập nhật thông tin bệnh nhân
        $patient = $application->patient;
        $patient->update([
            'insurance_id' => $application->insurance_id,
        ]);

        return redirect()->route('admin.insurance-applications.index')
            ->with('success', 'Đã duyệt hồ sơ BHYT thành công!');
    }

    // Admin: Từ chối hồ sơ
    public function adminReject(Request $request, $id)
    {
        $application = InsuranceApplication::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $application->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.insurance-applications.index')
            ->with('success', 'Đã từ chối hồ sơ BHYT.');
    }

    // Bệnh nhân: Xem trạng thái hồ sơ
    public function status()
    {
        try {
            $patient = $this->getAuthenticatedPatient();
            
            $applications = $patient->insuranceApplications()
                ->with(['healthInsurance', 'approvedBy'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('patients.insurance.status', compact('applications'));
        } catch (\Exception $e) {
            return redirect()->route('patient.login')->with('error', $e->getMessage());
        }
    }

    private function getAuthenticatedPatient()
    {
        $patientId = session('patient_id');
        if (!$patientId) {
            throw new \Exception('Phiên đăng nhập đã hết hạn.');
        }
        
        $patient = Patient::find($patientId);
        if (!$patient) {
            session()->forget(['patient_id', 'patient_name', 'patient_email']);
            throw new \Exception('Thông tin tài khoản không hợp lệ.');
        }
        
        return $patient;
    }
} 
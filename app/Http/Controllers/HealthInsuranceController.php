<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HealthInsurance;
use App\Models\InsuranceApplication;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HealthInsuranceController extends Controller
{
    // Hiển thị danh sách tất cả thẻ BHYT
    public function index()
    {
        $insurances = HealthInsurance::all();
        
        // Lấy danh sách hồ sơ đăng ký BHYT
        $applications = InsuranceApplication::with(['patient', 'healthInsurance'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.insurances.index', compact('insurances', 'applications'));
    }

    // Hiển thị chi tiết 1 thẻ BHYT
    public function show($id)
    {
        $insurance = HealthInsurance::findOrFail($id);
        return view('admin.insurances.show', compact('insurance'));
    }

    //  Thêm chức năng mở rộng: Tìm hoặc tự động tạo BHYT
    public function findOrCreate($id)
    {
        $insurance = HealthInsurance::firstOrCreate(
            ['id' => $id],
            [
                'register_date' => Carbon::now()->toDateString(),
                'expire_date' => Carbon::now()->addYear()->toDateString(),
            ]
        );

        return response()->json($insurance);
    }

    // Duyệt hồ sơ BHYT
    public function approveApplication(Request $request, $id)
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

        return redirect()->route('admin.insurances.index')
            ->with('success', 'Đã duyệt hồ sơ BHYT thành công!');
    }

    // Từ chối hồ sơ BHYT
    public function rejectApplication(Request $request, $id)
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

        return redirect()->route('admin.insurances.index')
            ->with('success', 'Đã từ chối hồ sơ BHYT.');
    }

    // Xem chi tiết hồ sơ BHYT
    public function showApplication($id)
    {
        $application = InsuranceApplication::with(['patient', 'healthInsurance', 'approvedBy'])
            ->findOrFail($id);

        return view('admin.insurances.application-detail', compact('application'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Hospitalized;
use App\Models\Discharge;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\InsuranceApplication;

class AdminController extends Controller
{
    public function dashboard()
    {
        $functionStats = [
            'Bệnh nhân'      => Patient::count(),
            'Bác sĩ'         => Doctor::count(),
            'Đơn thuốc'      => Prescription::count(),
            'Nhập viện'      => Hospitalized::count(),
            'Xuất viện'      => Discharge::count(),
            'Sổ khám bệnh'   => MedicalRecord::count(),
        ];

        $patientCount = $functionStats['Bệnh nhân'];
        $doctorCount = $functionStats['Bác sĩ'];
        $prescriptionCount = $functionStats['Đơn thuốc'];

        $monthlyAdmissionsRaw = Hospitalized::selectRaw('MONTH(admission_date) as month, COUNT(*) as total')
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $monthlyDischargesRaw = Discharge::selectRaw('MONTH(discharge_date) as month, COUNT(*) as total')
            ->groupBy('month')->pluck('total', 'month')->toArray();

        $monthlyAdmissions = $monthlyDischarges = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyAdmissions[$i] = $monthlyAdmissionsRaw[$i] ?? 0;
            $monthlyDischarges[$i] = $monthlyDischargesRaw[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'functionStats',
            'monthlyAdmissions',
            'monthlyDischarges',
            'patientCount',
            'doctorCount',
            'prescriptionCount'
        ));
    }

    // 🔔 API lấy thông báo lịch hẹn mới
    public function getNewAppointmentNotifications()
    {
        // Lấy các lịch hẹn mới chưa được thông báo với trạng thái pending
        $newAppointments = Appointment::with(['patient', 'doctor', 'department'])
            ->where('status', 'pending')
            ->where('admin_notified', false) // Chỉ lấy những thông báo chưa đọc
            ->where('created_at', '>=', now()->subHours(24)) // Mở rộng thời gian lên 24h
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = $newAppointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'message' => "Lịch hẹn mới từ bệnh nhân {$appointment->patient->name} (ID: {$appointment->patient_id})",
                'patient_name' => $appointment->patient->name ?? 'N/A',
                'patient_id' => $appointment->patient_id,
                'doctor_name' => $appointment->doctor->name ?? 'Chưa phân công',
                'doctor_id' => $appointment->doctor_id,
                'department_name' => $appointment->department->name ?? 'Chưa rõ',
                'department_id' => $appointment->department_id,
                'appointment_date' => $appointment->appointment_date,
                'symptoms' => $appointment->symptoms,
                'created_at' => $appointment->created_at->format('d/m/Y H:i:s'),
                'time_ago' => $appointment->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    // 🔔 Đánh dấu thông báo đã đọc
    public function markNotificationAsRead(Request $request)
    {
        $appointmentIds = $request->input('appointment_ids', []);
        
        if (!empty($appointmentIds)) {
            Appointment::whereIn('id', $appointmentIds)
                ->update(['admin_notified' => true]);
        }

        return response()->json(['success' => true]);
    }

    // 🔔 API lấy số lượng thông báo chưa đọc
    public function getNotificationCount()
    {
        $appointmentCount = Appointment::where('status', 'pending')
            ->where('admin_notified', false)
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        $insuranceCount = InsuranceApplication::where('status', 'pending')
            ->where('admin_notified', false)
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        return response()->json([
            'appointment_count' => $appointmentCount,
            'insurance_count' => $insuranceCount,
            'total_count' => $appointmentCount + $insuranceCount
        ]);
    }

    // 🔔 API lấy thông báo đăng ký mức hỗ trợ viện phí mới
    public function getInsuranceNotifications()
    {
        // Lấy các đăng ký mức hỗ trợ mới chưa được thông báo
        $newInsuranceApplications = InsuranceApplication::with(['patient'])
            ->where('status', 'pending')
            ->where('admin_notified', false)
            ->where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = $newInsuranceApplications->map(function ($application) {
            return [
                'id' => $application->id,
                'type' => 'insurance',
                'patient_name' => $application->patient->name ?? 'N/A',
                'patient_id' => $application->patient_id,
                'insurance_id' => $application->insurance_id,
                'support_level' => $application->support_level,
                'support_level_text' => $application->support_level_text,
                'status' => $application->status,
                'status_text' => $application->status_text,
                'proof_images' => $application->proof_images,
                'admin_notes' => $application->admin_notes,
                'created_at' => $application->created_at->format('d/m/Y H:i:s'),
                'time_ago' => $application->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'notifications' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    // 🔔 Đánh dấu thông báo đăng ký mức hỗ trợ đã đọc
    public function markInsuranceNotificationAsRead(Request $request)
    {
        $applicationIds = $request->input('application_ids', []);
        
        if (!empty($applicationIds)) {
            InsuranceApplication::whereIn('id', $applicationIds)
                ->update(['admin_notified' => true]);
        }

        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Department;
use App\Models\DetailMedicalRecord;
use App\Models\Prescription;
use App\Models\DetailPrescription;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\Hospitalized;
use App\Models\Discharge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DoctorViewController extends Controller
{
    /**
     * Kiểm tra bác sĩ đã đăng nhập
     */
    protected function getAuthenticatedDoctor()
    {
        $doctor = Auth::guard('doctor')->user();
        if (!$doctor) {
            // Debug: Log để kiểm tra
            Log::info('Doctor authentication failed', [
                'session_id' => session()->getId(),
                'guard' => 'doctor',
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip()
            ]);
            return redirect()->route('doctor.login')->with('error', 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại!');
        }
        
        // Debug: Log thành công
        Log::info('Doctor authenticated successfully', [
            'doctor_id' => $doctor->id,
            'doctor_name' => $doctor->name,
            'session_id' => session()->getId()
        ]);
        
        return $doctor;
    }
    /**
     * Dashboard chính của bác sĩ
     */
    public function dashboard()
    {
        $doctor = Auth::guard('doctor')->user();
        if (!$doctor) {
            return redirect()->route('doctor.login')->with('error', 'Vui lòng đăng nhập để truy cập.');
        }
        
        // Tính toán thống kê thực tế
        $stats = [
            'today_appointments' => Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_date', today())
                ->count(),
            'pending_records' => DetailMedicalRecord::whereHas('prescription', function($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })->whereDate('exam_date', today())->count(),
            'total_prescriptions' => Prescription::where('doctor_id', $doctor->id)->count(),
            'patients_this_month' => DetailMedicalRecord::whereHas('prescription', function($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })->whereMonth('exam_date', now()->month)
              ->whereYear('exam_date', now()->year)
              ->distinct('patient_id')->count(),
            'hospitalized_patients' => Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })->whereDoesntHave('discharge')->count(),
            'discharges_this_month' => Discharge::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })->whereMonth('discharge_date', now()->month)
              ->whereYear('discharge_date', now()->year)->count(),
            'admissions_this_month' => Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })->whereMonth('admission_date', now()->month)
              ->whereYear('admission_date', now()->year)->count(),
            'total_admissions' => Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })->count(),
        ];
        
        // Lấy lịch khám hôm nay
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->with(['patient', 'department'])
            ->orderBy('appointment_date', 'asc')
            ->get();
        
        // Lấy bệnh nhân gần đây (7 ngày qua)
        $recentPatients = DetailMedicalRecord::whereHas('prescription', function($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
            ->with(['patient', 'prescription'])
            ->whereDate('exam_date', '>=', now()->subDays(7))
            ->orderBy('exam_date', 'desc')
            ->limit(5)
            ->get();
        
        // Lấy bệnh nhân đang nhập viện
        $hospitalizedPatients = Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })
            ->whereDoesntHave('discharge')
            ->with(['patient'])
            ->orderBy('admission_date', 'desc')
            ->limit(5)
            ->get();
        
        return view('doctors.dashboard', compact('doctor', 'stats', 'todayAppointments', 'recentPatients', 'hospitalizedPatients'));
    }

    /**
     *  Xem danh sách lịch khám đã phân công
     */
    public function appointments()
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient', 'department'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);
        
        return view('doctors.appointments', compact('appointments'));
    }

    /**
     * Form khám bệnh và ghi hồ sơ
     */
    public function examCreate($appointmentId = null)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $appointment = null;
        
        if ($appointmentId) {
            $appointment = Appointment::where('id', $appointmentId)
                ->where('doctor_id', $doctor->id)
                ->with(['patient'])
                ->firstOrFail();
            
            // Kiểm tra trạng thái appointment - chỉ cho phép khám khi đã được xác nhận
            if ($appointment->status !== 'confirmed') {
                return redirect()->route('doctors.appointments')
                    ->with('error', 'Chỉ có thể khám bệnh cho lịch hẹn đã được Admin xác nhận!');
            }
        }
        
        // Chỉ lấy những bệnh nhân có appointment đã được xác nhận hoặc không có appointment
        $patients = Patient::whereDoesntHave('appointments', function($query) {
                $query->where('status', 'pending');
            })
            ->orWhereHas('appointments', function($query) {
                $query->where('status', 'confirmed');
            })
            ->get();
        
        $departments = Department::all();
        
        return view('doctors.exam-create', compact('appointment', 'patients', 'departments'));
    }

    /**
     *  Lưu hồ sơ khám bệnh
     */
    public function examStore(Request $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'exam_date' => 'required|date',
            'disease_name' => 'required|string|max:255',
            'appointment_id' => 'nullable|exists:appointments,id'
        ]);

        // Kiểm tra appointment status nếu có appointment_id
        if ($request->appointment_id) {
            $appointment = Appointment::where('id', $request->appointment_id)
                ->where('doctor_id', $doctor->id)
                ->first();
            
            if (!$appointment || $appointment->status !== 'confirmed') {
                return redirect()->route('doctors.appointments')
                    ->with('error', 'Chỉ có thể khám bệnh cho lịch hẹn đã được Admin xác nhận!');
            }
        } else {
            // Kiểm tra xem bệnh nhân có appointment pending không
            $pendingAppointment = Appointment::where('patient_id', $request->patient_id)
                ->where('status', 'pending')
                ->first();
            
            if ($pendingAppointment) {
                return redirect()->route('doctors.exam.create')
                    ->with('error', 'Không thể khám bệnh cho bệnh nhân có lịch hẹn đang chờ xác nhận!');
            }
        }

        try {
            DB::beginTransaction();
            
            // Tạo medical_record_id duy nhất
            do {
                $medicalRecordId = 'MASKB_' . now()->format('Ymd') . '_' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            } while (DB::table('medical_records')->where('id', $medicalRecordId)->exists());
            
            // Tạo số thứ tự cho medical record (luôn bắt đầu từ 1 cho ID mới)
            $order = 1;
            
            // BƯỚC 1: Tạo record trong bảng medical_records trước
            DB::table('medical_records')->insert([
                'id' => $medicalRecordId,
                'order' => $order,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // BƯỚC 2: Sau đó tạo detail medical record
            $medicalRecord = DetailMedicalRecord::create([
                'medical_record_id' => $medicalRecordId,
                'patient_id' => $request->patient_id,
                'exam_date' => $request->exam_date,
                'disease_name' => $request->disease_name,
                'department_id' => $doctor->department_id,
                'prescription_id' => null // Sẽ cập nhật sau khi kê đơn
            ]);
            
            // Cập nhật trạng thái appointment nếu có
            if ($request->appointment_id) {
                $appointment = Appointment::find($request->appointment_id);
                if ($appointment && $appointment->doctor_id === $doctor->id) {
                    $appointment->update(['status' => 'completed']);
                }
            }
            
            DB::commit();
            
            return redirect()->route('doctors.exam.prescription', $medicalRecord->medical_record_id)
                ->with('success', 'Đã ghi hồ sơ khám bệnh thành công! Vui lòng kê đơn thuốc.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     *  Form kê đơn thuốc
     */
    public function prescriptionCreate($medicalRecordId = null)
    {
        $doctor = Auth::guard('doctor')->user();
        $medicalRecord = null;
        
        if ($medicalRecordId) {
            $medicalRecord = DetailMedicalRecord::where('medical_record_id', $medicalRecordId)
                ->with(['patient'])
                ->first();
        }
        
        // Chỉ lấy những bệnh nhân có appointment đã được xác nhận hoặc không có appointment
        $patients = Patient::whereDoesntHave('appointments', function($query) {
                $query->where('status', 'pending');
            })
            ->orWhereHas('appointments', function($query) {
                $query->where('status', 'confirmed');
            })
            ->get();
        
        $medicines = Medicine::all();
        
        return view('doctors.prescription-create', compact('medicalRecord', 'patients', 'medicines'));
    }

    /**
     *  Lưu đơn thuốc
     */
    public function prescriptionStore(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medical_record_id' => 'nullable|string',
            'general_instructions' => 'nullable|string|max:1000',
            'warnings' => 'nullable|string|max:500',
            'next_appointment' => 'nullable|date|after:today'
        ]);

        // Kiểm tra xem bệnh nhân có appointment pending không
        $pendingAppointment = Appointment::where('patient_id', $request->patient_id)
            ->where('status', 'pending')
            ->first();
        
        if ($pendingAppointment) {
            return redirect()->route('doctors.prescription.create')
                ->with('error', 'Không thể kê đơn thuốc cho bệnh nhân có lịch hẹn đang chờ xác nhận!');
        }

        // Validate medicines riêng biệt
        if ($request->has('medicines') && is_array($request->medicines)) {
            $medicines = array_filter($request->medicines, function($medicine) {
                return !empty($medicine['medicine_id']) && !empty($medicine['quantity']);
            });
            
            if (empty($medicines)) {
                return back()->withErrors(['error' => 'Vui lòng thêm ít nhất một loại thuốc với đầy đủ thông tin!']);
            }
            
            // Validate từng thuốc
            foreach ($medicines as $index => $medicine) {
                if (!empty($medicine['medicine_id']) && !empty($medicine['quantity'])) {
                    $request->validate([
                        "medicines.{$index}.medicine_id" => 'required|exists:medicines,id',
                        "medicines.{$index}.quantity" => 'required|integer|min:1|max:100'
                    ]);
                }
            }
        } else {
            return back()->withErrors(['error' => 'Vui lòng thêm ít nhất một loại thuốc!']);
        }

        try {
            DB::beginTransaction();
            
            // Tạo prescription_id duy nhất
            do {
                $prescriptionId = 'DT_' . now()->format('Ymd') . '_' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            } while (Prescription::where('id', $prescriptionId)->exists());
            
            // Tạo đơn thuốc
            $prescription = Prescription::create([
                'id' => $prescriptionId,
                'doctor_id' => $doctor->id,
                'patient_id' => $request->patient_id,
                'general_instructions' => $request->general_instructions,
                'warnings' => $request->warnings,
                'next_appointment' => $request->next_appointment
            ]);
            
            // Lưu chi tiết thuốc
            if ($request->has('medicines') && is_array($request->medicines)) {
                $medicines = array_filter($request->medicines, function($medicine) {
                    return !empty($medicine['medicine_id']) && !empty($medicine['quantity']);
                });
                
                foreach ($medicines as $medicine) {
                    \App\Models\DetailPrescription::create([
                        'prescription_id' => $prescriptionId,
                        'medicine_id' => $medicine['medicine_id'],
                        'quantity' => $medicine['quantity'],
                        'usage_instructions' => $medicine['usage_instructions'] ?? null,
                    ]);
                }
            }
            
            // Cập nhật medical record nếu có
            if ($request->medical_record_id) {
                DetailMedicalRecord::where('medical_record_id', $request->medical_record_id)
                    ->update(['prescription_id' => $prescriptionId]);
            }
            
            DB::commit();
            
            // Truyền thông báo thành công qua query string thay vì session
            return redirect()->route('doctors.prescriptions', ['success' => 'Đã kê đơn thuốc thành công!']);
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     *  Xem hồ sơ y tế bệnh nhân đã khám
     */
    public function medicalRecords()
    {
        $doctor = Auth::guard('doctor')->user();
        
        // Lấy hồ sơ y tế thông qua đơn thuốc mà bác sĩ đã kê
        $medicalRecords = DetailMedicalRecord::where(function($query) use ($doctor) {
                $query->whereHas('prescription', function($subQuery) use ($doctor) {
                    $subQuery->where('doctor_id', $doctor->id);
                })
                ->orWhere('department_id', $doctor->department_id);
            })
            ->with(['patient', 'department', 'prescription'])
            ->orderBy('exam_date', 'desc')
            ->paginate(15);
        
        return view('doctors.medical-records', compact('medicalRecords'));
    }

    /**
     * Xem chi tiết hồ sơ y tế
     */
    public function viewMedicalRecord($medicalRecordId)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $medicalRecord = DetailMedicalRecord::where('medical_record_id', $medicalRecordId)
            ->where(function($query) use ($doctor) {
                $query->whereHas('prescription', function($subQuery) use ($doctor) {
                    $subQuery->where('doctor_id', $doctor->id);
                })
                ->orWhere('department_id', $doctor->department_id);
            })
            ->with(['patient', 'department', 'prescription.details.medicine'])
            ->firstOrFail();
        
        return view('doctors.medical-record-detail', compact('medicalRecord'));
    }

    /**
     * Chỉnh sửa hồ sơ khám
     */
    public function editMedicalRecord($medicalRecordId)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $medicalRecord = DetailMedicalRecord::where('medical_record_id', $medicalRecordId)
            ->where(function($query) use ($doctor) {
                $query->whereHas('prescription', function($subQuery) use ($doctor) {
                    $subQuery->where('doctor_id', $doctor->id);
                })
                ->orWhere('department_id', $doctor->department_id);
            })
            ->with(['patient'])
            ->firstOrFail();
        
        return view('doctors.medical-record-edit', compact('medicalRecord'));
    }

    /**
     * Cập nhật hồ sơ khám
     */
    public function updateMedicalRecord(Request $request, $medicalRecordId)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $request->validate([
            'disease_name' => 'required|string|max:255',
            'exam_date' => 'required|date'
        ]);
        
        $medicalRecord = DetailMedicalRecord::where('medical_record_id', $medicalRecordId)
            ->where(function($query) use ($doctor) {
                $query->whereHas('prescription', function($subQuery) use ($doctor) {
                    $subQuery->where('doctor_id', $doctor->id);
                })
                ->orWhere('department_id', $doctor->department_id);
            })
            ->firstOrFail();
        
        $medicalRecord->update([
            'disease_name' => $request->disease_name,
            'exam_date' => $request->exam_date
        ]);
        
        return redirect()->route('doctors.medical-records')
            ->with('success', 'Đã cập nhật hồ sơ thành công!');
    }

    /**
     *  Quản lý đơn thuốc của bác sĩ
     */
    public function prescriptions()
    {
        $doctor = Auth::guard('doctor')->user();
        
        $prescriptions = Prescription::where('doctor_id', $doctor->id)
            ->with(['patient', 'details.medicine'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('doctors.prescriptions', compact('prescriptions'));
    }

    /**
     *  Xem chi tiết đơn thuốc
     */
    public function viewPrescription($prescriptionId)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $prescription = Prescription::where('id', $prescriptionId)
            ->where('doctor_id', $doctor->id)
            ->with(['patient', 'details.medicine'])
            ->firstOrFail();
        
        return view('doctors.prescription-detail', compact('prescription'));
    }

    /**
     * Chỉnh sửa đơn thuốc
     */
    public function editPrescription($prescriptionId)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $prescription = Prescription::where('id', $prescriptionId)
            ->where('doctor_id', $doctor->id)
            ->with(['patient', 'details.medicine'])
            ->firstOrFail();
        
        $medicines = Medicine::all();
        
        return view('doctors.prescription-edit', compact('prescription', 'medicines'));
    }

    /**
     * Cập nhật đơn thuốc
     */
    public function updatePrescription(Request $request, $prescriptionId)
    {
        $doctor = Auth::guard('doctor')->user();
        
        $request->validate([
            'medicines' => 'required|array|min:1',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1|max:100'
        ]);
        
        $prescription = Prescription::where('id', $prescriptionId)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();
        
        try {
            DB::beginTransaction();
            
            // Xóa chi tiết cũ
            DetailPrescription::where('prescription_id', $prescriptionId)->delete();
            
            // Tạo chi tiết mới
            foreach ($request->medicines as $medicine) {
                DetailPrescription::create([
                    'prescription_id' => $prescriptionId,
                    'medicine_id' => $medicine['medicine_id'],
                    'quantity' => $medicine['quantity']
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('doctors.prescriptions')
                ->with('success', 'Đã cập nhật đơn thuốc thành công!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     *  Thống kê khám bệnh
     */
    public function statistics()
    {
        $doctor = Auth::guard('doctor')->user();
        
        // Thống kê theo tháng hiện tại
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $monthlyStats = [
            'patients_count' => $this->getMonthlyPatients($doctor->id)->count(),
            'prescriptions_count' => Prescription::where('doctor_id', $doctor->id)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count(),
            'medical_records_count' => DetailMedicalRecord::whereHas('prescription', function($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
            ->whereMonth('exam_date', $currentMonth)
            ->whereYear('exam_date', $currentYear)
            ->count()
        ];
        
        // Thống kê theo ngày trong tháng
        $dailyStats = [];
        for ($day = 1; $day <= now()->daysInMonth; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day);
            $dailyStats[] = [
                'day' => $day,
                'patients' => DetailMedicalRecord::whereHas('prescription', function($query) use ($doctor) {
                    $query->where('doctor_id', $doctor->id);
                })
                ->whereDate('exam_date', $date)
                ->count()
            ];
        }
        
        // Top 5 bệnh thường gặp
        $topDiseases = DetailMedicalRecord::whereHas('prescription', function($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
            ->select('disease_name', DB::raw('count(*) as count'))
            ->groupBy('disease_name')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
        
        return view('doctors.statistics', compact('monthlyStats', 'dailyStats', 'topDiseases'));
    }

    /**
     *  Quản lý nhập viện - Danh sách bệnh nhân nhập viện
     */
    public function hospitalized()
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        // Lấy danh sách nhập viện của bệnh nhân mà bác sĩ đã khám
        $hospitalizations = \App\Models\Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })
            ->with(['patient', 'discharge'])
            ->orderBy('admission_date', 'desc')
            ->paginate(15);
        
        // Tính toán thống kê
        $stats = [
            'total' => \App\Models\Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })->count(),
            'today' => \App\Models\Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })->whereDate('admission_date', today())->count(),
            'treating' => \App\Models\Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })->whereDoesntHave('discharge')->count(),
            'discharged' => \App\Models\Hospitalized::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })->whereHas('discharge')->count(),
        ];
        
        return view('doctors.hospitalized.index', compact('hospitalizations', 'stats'));
    }

    /**
     *  Form thêm nhập viện
     */
    public function hospitalizedCreate()
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        // Lấy danh sách bệnh nhân mà bác sĩ đã khám
        $patients = Patient::whereHas('detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })
            ->get();
        
        return view('doctors.hospitalized.create', compact('patients'));
    }

    /**
     *  Lưu thông tin nhập viện
     */
    public function hospitalizedStore(Request $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'admission_date' => 'required|date',
            'room' => 'required|string|max:10',
            'bed' => 'required|integer|min:1',
            'reason' => 'required|string|max:500',
            'diagnosis' => 'required|string|max:500',
        ]);

        // Kiểm tra xem bệnh nhân đã được bác sĩ khám chưa
        $hasExamined = DetailMedicalRecord::where('patient_id', $request->patient_id)
            ->where('department_id', $doctor->department_id)
            ->exists();
        
        if (!$hasExamined) {
            return back()->withErrors(['error' => 'Bạn chỉ có thể nhập viện cho bệnh nhân đã được khám tại khoa của bạn!']);
        }

        try {
            \App\Models\Hospitalized::create([
                'patient_id' => $request->patient_id,
                'admission_date' => $request->admission_date,
                'room' => $request->room,
                'bed' => $request->bed,
                'reason' => $request->reason,
                'diagnosis' => $request->diagnosis,
            ]);

            return redirect()->route('doctors.hospitalized.index')
                ->with('success', 'Thêm thông tin nhập viện thành công!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     *  Form chỉnh sửa nhập viện
     */
    public function hospitalizedEdit($patient_id, $room, $bed)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $hospitalized = \App\Models\Hospitalized::where('patient_id', $patient_id)
            ->where('room', $room)
            ->where('bed', $bed)
            ->firstOrFail();
        
        // Kiểm tra xem bệnh nhân có thuộc khoa của bác sĩ không
        $hasExamined = DetailMedicalRecord::where('patient_id', $patient_id)
            ->where('department_id', $doctor->department_id)
            ->exists();
        
        if (!$hasExamined) {
            return redirect()->route('doctors.hospitalized.index')
                ->with('error', 'Bạn không có quyền chỉnh sửa thông tin nhập viện này!');
        }
        
        $patients = Patient::whereHas('detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })
            ->get();
        
        return view('doctors.hospitalized.edit', compact('hospitalized', 'patients'));
    }

    /**
     *  Cập nhật thông tin nhập viện
     */
    public function hospitalizedUpdate(Request $request, $patient_id, $room, $bed)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $request->validate([
            'admission_date' => 'required|date',
            'bed' => 'required|integer|min:1',
            'reason' => 'required|string|max:500',
            'diagnosis' => 'required|string|max:500',
        ]);

        $hospitalized = \App\Models\Hospitalized::where('patient_id', $patient_id)
            ->where('room', $room)
            ->where('bed', $bed)
            ->firstOrFail();
        
        // Kiểm tra xem bệnh nhân có thuộc khoa của bác sĩ không
        $hasExamined = DetailMedicalRecord::where('patient_id', $patient_id)
            ->where('department_id', $doctor->department_id)
            ->exists();
        
        if (!$hasExamined) {
            return redirect()->route('doctors.hospitalized.index')
                ->with('error', 'Bạn không có quyền cập nhật thông tin nhập viện này!');
        }

        try {
            $hospitalized->update([
                'admission_date' => $request->admission_date,
                'bed' => $request->bed,
                'reason' => $request->reason,
                'diagnosis' => $request->diagnosis,
            ]);

            return redirect()->route('doctors.hospitalized.index')
                ->with('success', 'Cập nhật nhập viện thành công!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     *  Xóa thông tin nhập viện
     */
    public function hospitalizedDestroy($patient_id, $room, $bed)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $hospitalized = \App\Models\Hospitalized::where('patient_id', $patient_id)
            ->where('room', $room)
            ->where('bed', $bed)
            ->firstOrFail();
        
        // Kiểm tra xem bệnh nhân có thuộc khoa của bác sĩ không
        $hasExamined = DetailMedicalRecord::where('patient_id', $patient_id)
            ->where('department_id', $doctor->department_id)
            ->exists();
        
        if (!$hasExamined) {
            return redirect()->route('doctors.hospitalized.index')
                ->with('error', 'Bạn không có quyền xóa thông tin nhập viện này!');
        }

        try {
            $hospitalized->delete();
            return redirect()->route('doctors.hospitalized.index')
                ->with('success', 'Xoá thông tin nhập viện thành công!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     *  Quản lý xuất viện - Danh sách bệnh nhân xuất viện
     */
    public function discharges()
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        // Lấy danh sách xuất viện của bệnh nhân mà bác sĩ đã khám
        $discharges = \App\Models\Discharge::whereHas('patient.detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })
            ->with(['patient'])
            ->orderBy('discharge_date', 'desc')
            ->paginate(15);
        
        return view('doctors.discharges.index', compact('discharges'));
    }

    /**
     *  Form thêm xuất viện
     */
    public function dischargesCreate()
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        // Lấy danh sách bệnh nhân mà bác sĩ đã khám và đang nhập viện
        $patients = Patient::whereHas('detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })
            ->whereHas('hospitalized')
            ->get();
        
        return view('doctors.discharges.create', compact('patients'));
    }

    /**
     *  Lưu thông tin xuất viện
     */
    public function dischargesStore(Request $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'discharge_date' => 'required|date',
            'discharge_reason' => 'required|string|max:500',
            'treatment_result' => 'required|string|max:500',
            'follow_up_instructions' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra xem bệnh nhân đã được bác sĩ khám chưa
        $hasExamined = DetailMedicalRecord::where('patient_id', $request->patient_id)
            ->where('department_id', $doctor->department_id)
            ->exists();
        
        if (!$hasExamined) {
            return back()->withErrors(['error' => 'Bạn chỉ có thể xuất viện cho bệnh nhân đã được khám tại khoa của bạn!']);
        }

        // Kiểm tra xem bệnh nhân có đang nhập viện không
        $isHospitalized = \App\Models\Hospitalized::where('patient_id', $request->patient_id)->exists();
        if (!$isHospitalized) {
            return back()->withErrors(['error' => 'Bệnh nhân này chưa nhập viện!']);
        }

        try {
            \App\Models\Discharge::create([
                'patient_id' => $request->patient_id,
                'discharge_date' => $request->discharge_date,
                'discharge_reason' => $request->discharge_reason,
                'treatment_result' => $request->treatment_result,
                'follow_up_instructions' => $request->follow_up_instructions,
            ]);

            return redirect()->route('doctors.discharges.index')
                ->with('success', 'Thêm thông tin xuất viện thành công!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     *  Form chỉnh sửa xuất viện
     */
    public function dischargesEdit($patient_id, $discharge_date)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $discharge = \App\Models\Discharge::where('patient_id', $patient_id)
            ->where('discharge_date', $discharge_date)
            ->firstOrFail();
        
        // Kiểm tra xem bệnh nhân có thuộc khoa của bác sĩ không
        $hasExamined = DetailMedicalRecord::where('patient_id', $patient_id)
            ->where('department_id', $doctor->department_id)
            ->exists();
        
        if (!$hasExamined) {
            return redirect()->route('doctors.discharges.index')
                ->with('error', 'Bạn không có quyền chỉnh sửa thông tin xuất viện này!');
        }
        
        $patients = Patient::whereHas('detailMedicalRecords', function($query) use ($doctor) {
                $query->where('department_id', $doctor->department_id);
            })
            ->get();
        
        return view('doctors.discharges.edit', compact('discharge', 'patients'));
    }

    /**
     *  Cập nhật thông tin xuất viện
     */
    public function dischargesUpdate(Request $request, $patient_id, $discharge_date)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $request->validate([
            'discharge_date' => 'required|date',
            'discharge_reason' => 'required|string|max:500',
            'treatment_result' => 'required|string|max:500',
            'follow_up_instructions' => 'nullable|string|max:1000',
        ]);

        $discharge = \App\Models\Discharge::where('patient_id', $patient_id)
            ->where('discharge_date', $discharge_date)
            ->firstOrFail();
        
        // Kiểm tra xem bệnh nhân có thuộc khoa của bác sĩ không
        $hasExamined = DetailMedicalRecord::where('patient_id', $patient_id)
            ->where('department_id', $doctor->department_id)
            ->exists();
        
        if (!$hasExamined) {
            return redirect()->route('doctors.discharges.index')
                ->with('error', 'Bạn không có quyền cập nhật thông tin xuất viện này!');
        }

        try {
            $discharge->update([
                'discharge_date' => $request->discharge_date,
                'discharge_reason' => $request->discharge_reason,
                'treatment_result' => $request->treatment_result,
                'follow_up_instructions' => $request->follow_up_instructions,
            ]);

            return redirect()->route('doctors.discharges.index')
                ->with('success', 'Cập nhật xuất viện thành công!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    /**
     *  Xóa thông tin xuất viện
     */
    public function dischargesDestroy($patient_id, $discharge_date)
    {
        $doctor = $this->getAuthenticatedDoctor();
        if ($doctor instanceof \Illuminate\Http\RedirectResponse) {
            return $doctor;
        }
        
        $discharge = \App\Models\Discharge::where('patient_id', $patient_id)
            ->where('discharge_date', $discharge_date)
            ->firstOrFail();
        
        // Kiểm tra xem bệnh nhân có thuộc khoa của bác sĩ không
        $hasExamined = DetailMedicalRecord::where('patient_id', $patient_id)
            ->where('department_id', $doctor->department_id)
            ->exists();
        
        if (!$hasExamined) {
            return redirect()->route('doctors.discharges.index')
                ->with('error', 'Bạn không có quyền xóa thông tin xuất viện này!');
        }

        try {
            $discharge->delete();
            return redirect()->route('doctors.discharges.index')
                ->with('success', 'Xoá thông tin xuất viện thành công!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }







    // Helper methods
    private function getTodayAppointments($doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', today())
            ->with(['patient']);
    }

    private function getPendingMedicalRecords($doctorId)
    {
        return DetailMedicalRecord::where('department_id', $doctorId)
            ->whereNull('prescription_id')
            ->with(['patient']);
    }

    private function getMonthlyPatients($doctorId)
    {
        return DetailMedicalRecord::whereHas('prescription', function($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->whereMonth('exam_date', now()->month)
            ->whereYear('exam_date', now()->year)
            ->distinct('patient_id')
            ->with(['patient']);
    }

    private function getRecentPatients($doctorId)
    {
        return DetailMedicalRecord::whereHas('prescription', function($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->with(['patient'])
            ->orderBy('exam_date', 'desc');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\DetailMedicalRecord;
use App\Models\Prescription;
use App\Models\DetailPrescription;
use App\Models\Bill;
use App\Models\Relative;
use App\Models\Hospitalized;
use App\Models\Discharge;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Services\BillCalculationService;
use Illuminate\Support\Facades\Log;

class PatientViewController extends Controller
{
    // Lấy thông tin bệnh nhân đã đăng nhập
    private function getAuthenticatedPatient()
    {
        $patientId = session('patient_id');
        if (!$patientId) {
            return redirect()->route('patient.login')->with('error', 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại!');
        }
        
        $patient = Patient::find($patientId);
        if (!$patient) {
            session()->forget(['patient_id', 'patient_name', 'patient_email']);
            return redirect()->route('patient.login')->with('error', 'Thông tin tài khoản không hợp lệ. Vui lòng đăng nhập lại!');
        }
        
        return $patient;
    }

    // Xem hồ sơ y tế
    public function medicalRecords()
    {
        $patient = $this->getAuthenticatedPatient();
        $patientId = $patient->id;
        
        // Lấy thông tin chi tiết hồ sơ khám bệnh của bệnh nhân
        $medicalRecords = DetailMedicalRecord::where('patient_id', $patientId)
            ->with(['department', 'prescription'])
            ->orderBy('exam_date', 'desc')
            ->get();

        return view('patients.medical-records', compact('medicalRecords'));
    }

    // Xem lịch hẹn
    public function appointments()
    {
        $patient = $this->getAuthenticatedPatient();
        $patientId = $patient->id;
        
        // Lấy tất cả lịch hẹn của bệnh nhân
        $appointments = Appointment::where('patient_id', $patientId)
            ->with(['doctor', 'department'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('patients.appointments', compact('appointments'));
    }

    // Xem đơn thuốc
    public function prescriptions()
    {
        $patient = $this->getAuthenticatedPatient();
        $patientId = $patient->id;
        
        // Lấy tất cả đơn thuốc của bệnh nhân
        $prescriptions = Prescription::where('patient_id', $patientId)
            ->with(['doctor', 'details.medicine'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patients.prescriptions', compact('prescriptions'));
    }

    // Xem thông tin nhập/xuất viện
    public function hospitalization()
    {
        $patient = $this->getAuthenticatedPatient();
        $patientId = $patient->id;
        
        // Lấy thông tin nhập viện
        $hospitalizations = Hospitalized::where('patient_id', $patientId)
            ->orderBy('admission_date', 'desc')
            ->get();

        // Lấy thông tin xuất viện
        $discharges = Discharge::where('patient_id', $patientId)
            ->orderBy('discharge_date', 'desc')
            ->get();

        return view('patients.hospitalization', compact('hospitalizations', 'discharges'));
    }

    // Đặt thuốc
    public function orderMedicine(Request $request)
    {
        $patient = $this->getAuthenticatedPatient();
        
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id'
        ]);

        try {
            // Debug: Log thông tin request
            Log::info('Đặt thuốc - Patient ID: ' . $patient->id . ', Prescription ID: ' . $request->prescription_id);
            
            // Lấy thông tin đơn thuốc
            $prescription = Prescription::where('id', $request->prescription_id)
                ->where('patient_id', $patient->id)
                ->with(['details.medicine', 'doctor'])
                ->firstOrFail();

            // Tạo bill_id duy nhất
            do {
                $billId = 'HD_' . now()->format('Ymd') . '_' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            } while (Bill::where('id', $billId)->exists());

            // Tính tổng tiền gốc
            $totalAmount = 0;
            foreach ($prescription->details as $detail) {
                $totalAmount += ($detail->medicine->price ?? 0) * ($detail->quantity ?? 1);
            }

            // Sử dụng service tính toán bảo hiểm
            $billCalculationService = new BillCalculationService();
            $calculation = $billCalculationService->calculateBillWithInsurance($totalAmount, $patient);

            // Tạo hóa đơn với thông tin bảo hiểm
            $bill = Bill::create([
                'id' => $billId,
                'patient_id' => $patient->id,
                'prescription_id' => $prescription->id,
                'health_insurance_id' => $calculation['has_insurance'] ? $calculation['insurance_id'] : null,
                'total' => $calculation['patient_amount'], // Số tiền bệnh nhân phải trả
                'status' => 'pending',
                'bill_date' => now(),
                'payment_method' => 'cash',
                'notes' => 'Đặt thuốc từ đơn thuốc #' . $prescription->id . 
                          ($calculation['has_insurance'] ? ' (Có BHYT: ' . $calculation['insurance_percentage'] . '%)' : ' (Không có BHYT)')
            ]);

            // Redirect đến trang bills với thông báo
            $message = 'Đã tạo hóa đơn đặt thuốc thành công! Mã hóa đơn: ' . $billId;
            if ($calculation['has_insurance'] && $calculation['insurance_amount'] > 0) {
                $message .= ' - BHYT chi trả: ' . number_format($calculation['insurance_amount'], 0, ',', '.') . ' VNĐ';
            }
            
            return redirect()->route('patients.bills')->with('success', $message);

        } catch (\Exception $e) {
            // Debug: Log lỗi để kiểm tra
            Log::error('Lỗi đặt thuốc: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Thanh toán hóa đơn
    public function payBill(Request $request)
    {
        $patient = $this->getAuthenticatedPatient();
        
        $request->validate([
            'bill_id' => 'required|exists:bills,id'
        ]);

        try {
            // Lấy thông tin hóa đơn
            $bill = Bill::where('id', $request->bill_id)
                ->where('patient_id', $patient->id)
                ->firstOrFail();

            // Cập nhật trạng thái thanh toán
            $bill->update([
                'status' => 'paid',
                'payment_date' => now(),
                'payment_method' => 'cash'
            ]);

            // Redirect đến trang bills với thông báo
            return redirect()->route('patients.bills')
                ->with('success', 'Thanh toán thành công! Hóa đơn #' . $bill->id . ' đã được thanh toán.');

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Xóa hóa đơn
    public function deleteBill(Request $request)
    {
        $patient = $this->getAuthenticatedPatient();
        
        $request->validate([
            'bill_id' => 'required|exists:bills,id'
        ]);

        try {
            // Lấy thông tin hóa đơn
            $bill = Bill::where('id', $request->bill_id)
                ->where('patient_id', $patient->id)
                ->where('status', 'pending') // Chỉ cho phép xóa hóa đơn chưa thanh toán
                ->firstOrFail();

            // Xóa hóa đơn
            $bill->delete();

            // Redirect đến trang bills với thông báo
            return redirect()->route('patients.bills')
                ->with('success', 'Đã xóa hóa đơn #' . $bill->id . ' thành công!');

        } catch (\Exception $e) {
            return back()->with('error', 'Không thể xóa hóa đơn này. Chỉ có thể xóa hóa đơn chưa thanh toán.');
        }
    }

    // Xem thông tin thân nhân
    public function relatives()
    {
        $patient = $this->getAuthenticatedPatient();
        $patientId = $patient->id;
        
        $relatives = Relative::where('patient_id', $patientId)->get();

        return view('patients.relatives', compact('relatives'));
    }

    // Xem hóa đơn
    public function bills()
    {
        $patient = $this->getAuthenticatedPatient();
        $patientId = $patient->id;
        
        // Load patient với relationship insurance
        $patient = Patient::with('insurance')->find($patientId);
        
        $bills = Bill::where('patient_id', $patientId)
            ->with(['prescription.details.medicine', 'healthInsurance'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patients.bills', compact('bills', 'patient'));
    }

    // Quản lý tài khoản
    public function account()
    {
        $patient = $this->getAuthenticatedPatient();
        $patient = Patient::with('typePatient')->find($patient->id);

        return view('patients.account', compact('patient'));
    }

    // Cập nhật thông tin tài khoản
    public function updateAccount(Request $request)
    {
        $patient = $this->getAuthenticatedPatient();
        $patient = Patient::find($patient->id);

        $request->validate([
            'name' => 'required|max:50',
            'phone' => 'nullable|max:15',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|max:100',
            'dob' => 'nullable|date',
            'health_insurance_id' => 'nullable|max:15',
        ]);

        $patient->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'date' => $request->dob, // Map to correct field name
            'insurance_id' => $request->health_insurance_id, // Map to correct field
        ]);

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }

    // Đổi mật khẩu
    public function changePassword(Request $request)
    {
        $patient = $this->getAuthenticatedPatient();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $patient = Patient::find($patient->id);

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $patient->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng!']);
        }

        // Cập nhật mật khẩu mới
        $patient->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Xem danh sách thiết bị y tế
    public function machines()
    {
        $this->getAuthenticatedPatient();

        // Dữ liệu mẫu thiết bị y tế
        $machines = [
            ['id' => 'TB001', 'name' => 'Máy X-quang', 'department' => 'Khoa Chẩn đoán hình ảnh', 'status' => 'Hoạt động'],
            ['id' => 'TB002', 'name' => 'Máy CT Scanner', 'department' => 'Khoa Chẩn đoán hình ảnh', 'status' => 'Hoạt động'],
            ['id' => 'TB003', 'name' => 'Máy MRI', 'department' => 'Khoa Chẩn đoán hình ảnh', 'status' => 'Bảo trì'],
            ['id' => 'TB004', 'name' => 'Máy siêu âm', 'department' => 'Khoa Sản', 'status' => 'Hoạt động'],
            ['id' => 'TB005', 'name' => 'Máy nội soi', 'department' => 'Khoa Tiêu hóa', 'status' => 'Hoạt động'],
            ['id' => 'TB006', 'name' => 'Máy đo điện tim', 'department' => 'Khoa Tim mạch', 'status' => 'Hoạt động'],
            ['id' => 'TB007', 'name' => 'Máy thở', 'department' => 'Khoa Hồi sức cấp cứu', 'status' => 'Hoạt động'],
            ['id' => 'TB008', 'name' => 'Máy xét nghiệm máu', 'department' => 'Khoa Xét nghiệm', 'status' => 'Hoạt động'],
        ];

        return view('patients.machines', compact('machines'));
    }

    public function createRelative()
    {
        return view('patients.relatives.create');
    }

    public function storeRelative(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'name' => 'required|string|max:100',
            'gender' => 'required|in:Nam,Nữ',
            'date_of_birth' => 'required|date',
            'relation' => 'required|string|max:50',
        ]);

        \App\Models\Relative::create([
            'patient_id' => $request->patient_id,
            'name' => $request->name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'relation' => $request->relation,
        ]);

        return redirect()->route('patients.relatives')->with('success', 'Thêm thân nhân thành công!');
    }
}
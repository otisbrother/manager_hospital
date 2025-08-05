<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // 📄 Danh sách lịch hẹn
    public function index(Request $request)
{
    $query = Appointment::with(['patient', 'doctor', 'department']);

    // 🔍 Nếu có từ khóa tìm kiếm
    if ($request->filled('search')) {
        $keyword = $request->search;
        $query->where(function ($q) use ($keyword) {
            $q->where('patient_id', 'like', "%$keyword%")
              ->orWhere('doctor_id', 'like', "%$keyword%")
              ->orWhere('department_id', 'like', "%$keyword%")
              ->orWhere('appointment_date', 'like', "%$keyword%")
              ->orWhere('symptoms', 'like', "%$keyword%");
        });
    }

    $appointments = $query->orderBy('appointment_date', 'desc')->paginate(10);

    return view('admin.appointments.index', compact('appointments'));
}


    // ➕ Form tạo mới
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $departments = Department::all();
        return view('admin.appointments.create', compact('patients', 'doctors', 'departments'));
    }

    // 💾 Lưu lịch hẹn
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'department_id' => 'nullable|exists:departments,id',
            'appointment_date' => 'required|date',
            'symptoms' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointmentData = $request->all();
        $appointmentData['admin_notified'] = false; // Đảm bảo thông báo admin được reset

        Appointment::create($appointmentData);

        return redirect()->route('admin.appointments.index')->with('success', 'Đã tạo lịch hẹn thành công.');
    }

     public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor', 'department'])->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }

    // ✏️ Form chỉnh sửa
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::all();
        $departments = Department::all();

        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors', 'departments'));
    }

    // 📝 Cập nhật lịch hẹn
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'department_id' => 'nullable|exists:departments,id',
            'appointment_date' => 'required|date',
            'symptoms' => 'required|string|max:255',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($request->all());

        return redirect()->route('admin.appointments.index')->with('success', 'Đã cập nhật lịch hẹn.');
    }

    // 🗑️ Xóa lịch hẹn
    public function destroy($id)
    {
        Appointment::destroy($id);
        return redirect()->route('admin.appointments.index')->with('success', 'Đã xoá lịch hẹn.');
    }
    

   
   public function updateStatus(Request $request, $id)
   {
    $request->validate([
        'status' => 'required|in:pending,confirmed,completed,cancelled'
    ]);

    $appointment = Appointment::findOrFail($id);
    $appointment->status = $request->status;
    $appointment->save();

    return response()->json(['success' => true, 'message' => 'Trạng thái đã được cập nhật.']);
   }

   // 📝 Form đặt lịch hẹn cho bệnh nhân
   public function patientCreate()
   {
       // Kiểm tra đăng nhập bệnh nhân
       if (!session()->has('patient_id')) {
           return redirect()->route('patient.login');
       }

       $doctors = Doctor::with('department')->get();
       $departments = Department::all();
       
       return view('patients.appointment.create', compact('doctors', 'departments'));
   }

   // 💾 Lưu lịch hẹn từ bệnh nhân
   public function patientStore(Request $request)
   {
       // Kiểm tra đăng nhập bệnh nhân
       if (!session()->has('patient_id')) {
           return redirect()->route('patient.login');
       }

       $request->validate([
           'doctor_id' => 'required|exists:doctors,id', 
           'department_id' => 'required|exists:departments,id',
           'appointment_date' => 'required|date|after:now',
           'symptoms' => 'required|string|max:500',
       ], [
           'doctor_id.required' => 'Vui lòng chọn bác sĩ',
           'doctor_id.exists' => 'Bác sĩ không tồn tại',
           'department_id.required' => 'Vui lòng chọn khoa',
           'department_id.exists' => 'Khoa không tồn tại',
           'appointment_date.required' => 'Vui lòng chọn ngày hẹn',
           'appointment_date.after' => 'Ngày hẹn phải sau thời điểm hiện tại',
           'symptoms.required' => 'Vui lòng mô tả triệu chứng',
           'symptoms.max' => 'Triệu chứng không được quá 500 ký tự',
       ]);

       // Kiểm tra bác sĩ có thuộc khoa được chọn không
       if ($request->doctor_id && $request->department_id) {
           $doctor = Doctor::find($request->doctor_id);
           if ($doctor && $doctor->department_id !== $request->department_id) {
               return back()->withErrors([
                   'doctor_department_mismatch' => 'Bạn đã chọn sai trường khoa hoặc bác sĩ. Vui lòng nhập lại.'
               ])->withInput();
           }
       }

       // Tạo lịch hẹn với trạng thái pending
       Appointment::create([
           'patient_id' => session('patient_id'),
           'doctor_id' => $request->doctor_id,
           'department_id' => $request->department_id,
           'appointment_date' => $request->appointment_date,
           'symptoms' => $request->symptoms,
           'status' => 'pending',
           'notes' => 'Đặt lịch từ bệnh nhân',
       ]);  

       return redirect()->route('patient.home')->with('success', 'Đặt lịch hẹn thành công! Vui lòng chờ xác nhận từ bệnh viện.');
   }

}

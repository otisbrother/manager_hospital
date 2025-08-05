<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TypePatient;
use App\Models\HealthInsurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with(['typePatient', 'insurance']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        $types = TypePatient::all();
        $insurances = HealthInsurance::all();
        return view('admin.patients.create', compact('types', 'insurances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:patients,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:patients,email',
            'password' => 'required|string|min:6',
            'gender' => 'required|in:Nam,Nữ',
            'date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string',
            'patient_type_id' => 'required|exists:type_patients,id',
            'insurance_id' => 'nullable|string|max:15', // Thay đổi từ exists sang string
        ]);

        $data = $request->all();
        
        // Hash password
        $data['password'] = Hash::make($data['password']);
        
        // Tự động tạo BHYT nếu có mã BHYT và chưa tồn tại
        if (!empty($data['insurance_id'])) {
            $existingInsurance = HealthInsurance::find($data['insurance_id']);
            
            if (!$existingInsurance) {
                // Tạo BHYT mới với ngày đăng ký là hôm nay và hết hạn sau 2 năm
                HealthInsurance::create([
                    'id' => $data['insurance_id'],
                    'register_date' => Carbon::now()->format('Y-m-d'),
                    'expire_date' => Carbon::now()->addYears(2)->format('Y-m-d'),
                ]);
            }
        }

        Patient::create($data);
        
        return redirect()->route('admin.patients.index')->with('success', 'Thêm bệnh nhân thành công!');
    }

    public function show($id)
    {
        $patient = Patient::with(['typePatient', 'insurance'])->findOrFail($id);
        return view('admin.patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        $types = TypePatient::all();
        $insurances = HealthInsurance::all();
        return view('admin.patients.edit', compact('patient', 'types', 'insurances'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:patients,email,' . $id,
            'gender' => 'required|in:Nam,Nữ',
            'date' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string',
            'patient_type_id' => 'required|exists:type_patients,id',
            'insurance_id' => 'nullable|string|max:15', // Thay đổi từ exists sang string
        ]);

        $data = $request->all();
        
        // Chỉ hash password nếu có nhập password mới
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Không cập nhật password nếu để trống
        }
        
        // Tự động tạo BHYT nếu có mã BHYT và chưa tồn tại
        if (!empty($data['insurance_id'])) {
            $existingInsurance = HealthInsurance::find($data['insurance_id']);
            
            if (!$existingInsurance) {
                // Tạo BHYT mới với ngày đăng ký là hôm nay và hết hạn sau 2 năm
                HealthInsurance::create([
                    'id' => $data['insurance_id'],
                    'register_date' => Carbon::now()->format('Y-m-d'),
                    'expire_date' => Carbon::now()->addYears(2)->format('Y-m-d'),
                ]);
            }
        }

        $patient = Patient::findOrFail($id);
        $patient->update($data);
        return redirect()->route('admin.patients.index')->with('success', 'Cập nhật bệnh nhân thành công!');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Xóa bệnh nhân thành công!');
    }
}


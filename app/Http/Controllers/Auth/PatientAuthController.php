<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\TypePatient;
use App\Models\HealthInsurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientAuthController extends Controller
{
    public function showLoginForm()
    {
        // Kiểm tra session bệnh nhân
        if (session('patient_id')) {
            // Kiểm tra timeout
            $lastActivity = session('patient_last_activity');
            $timeout = 10 * 60; // 10 phút
            
            if ($lastActivity && (time() - $lastActivity) <= $timeout) {
                return redirect()->route('patients.home');
            } else {
                // Session đã hết hạn, xóa session cũ
                session()->flush();
            }
        }
        return view('auth.patient.login');
    }

    public function showRegisterForm()
    {
        // Kiểm tra session bệnh nhân
        if (session('patient_id')) {
            // Kiểm tra timeout
            $lastActivity = session('patient_last_activity');
            $timeout = 10 * 60; // 10 phút
            
            if ($lastActivity && (time() - $lastActivity) <= $timeout) {
                return redirect()->route('patients.home');
            } else {
                // Session đã hết hạn, xóa session cũ
                session()->flush();
            }
        }
        return view('auth.patient.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Tìm patient theo email
        $patient = Patient::where('email', $request->email)->first();
        
        if (!$patient) {
            return back()->withErrors(['email' => 'Email không tồn tại trong hệ thống.'])->withInput();
        }

        // Kiểm tra password
        if (!Hash::check($request->password, $patient->password)) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không chính xác.'])->withInput();
        }

        // Xóa session cũ và tạo session mới
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Login thủ công bằng session
        $request->session()->put('patient_id', $patient->id);
        $request->session()->put('patient_name', $patient->name);
        $request->session()->put('patient_email', $patient->email);
        $request->session()->put('patient_last_activity', time());
        
        return redirect()->route('patients.home')->with('success', 'Đăng nhập thành công!');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:patients,email',
            'password' => 'required|min:6|confirmed',
            'full_name' => 'required|string|max:30',
            'insurance_code' => 'nullable|string|max:15',
            'gender' => 'required|in:Nam,Nữ',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:10|regex:/^[0-9]+$/'
        ], [
            'phone.max' => 'Số điện thoại không được vượt quá 10 chữ số.',
            'phone.regex' => 'Số điện thoại chỉ được chứa chữ số.',
            'full_name.max' => 'Tên bệnh nhân không được vượt quá 30 ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'insurance_code.max' => 'Mã BHYT không được vượt quá 15 ký tự.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Lấy type_patient_id mặc định (có thể là 1 cho bệnh nhân thường)
        $typePatient = TypePatient::first();
        if (!$typePatient) {
            return back()->withErrors(['error' => 'Hệ thống chưa được cấu hình loại bệnh nhân.']);
        }

        // Tạo ID mới cho bệnh nhân (BNxxxxx)
        $lastPatient = Patient::orderBy('id', 'desc')->first();
        if ($lastPatient) {
            $lastNumber = (int)substr($lastPatient->id, 2); // Lấy số sau BN
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $newId = 'BN' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        // Tạo bệnh nhân mới
        $patient = Patient::create([
            'id' => $newId,
            'name' => $request->full_name, // Sử dụng 'name' thay vì 'full_name' 
            'email' => $request->email,
            'password' => $request->password, // Model sẽ tự động hash qua mutator
            'date' => $request->date_of_birth, // Sử dụng 'date' thay vì 'date_of_birth'
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone,
            'insurance_id' => $request->insurance_code, // Sử dụng 'insurance_id' thay vì 'insurance_code'
            'patient_type_id' => $typePatient->id, // Sử dụng 'patient_type_id' thay vì 'type_patient_id'
        ]);

        // Chuyển hướng về trang đăng nhập của patient
        return redirect()->route('patient.login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập để tiếp tục.');
    }

    public function logout(Request $request)
    {
        // Xóa toàn bộ session
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('patient.login')->with('success', 'Đăng xuất thành công!');
    }
} 
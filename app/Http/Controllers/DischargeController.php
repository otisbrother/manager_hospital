<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discharge;
use App\Models\Patient;

class DischargeController extends Controller
{
    // Hiển thị danh sách xuất viện
    public function index()
    {
        $discharges = Discharge::with('patient')->orderByDesc('discharge_date')->get();
        return view('admin.discharges.index', compact('discharges'));
    }

    // Form thêm mới
    public function create()
    {
        $patients = Patient::all();
        return view('admin.discharges.create', compact('patients'));
    }

    // Lưu dữ liệu mới
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'discharge_date' => 'required|date',
        ]);

        Discharge::create($request->only('patient_id', 'discharge_date'));

        return redirect()->route('admin.discharges.index')->with('success', 'Thêm xuất viện thành công');
    }

    // Hiển thị chi tiết một lần xuất viện
    public function show($patient_id, $discharge_date)
    {
        $discharge = Discharge::with('patient')
            ->where('patient_id', $patient_id)
            ->where('discharge_date', $discharge_date)
            ->firstOrFail();

        return view('discharges.show', compact('discharge'));
    }

    // Form chỉnh sửa xuất viện
    public function edit($patient_id, $discharge_date)
    {
        $discharge = Discharge::where('patient_id', $patient_id)
            ->where('discharge_date', $discharge_date)
            ->firstOrFail();

        $patients = Patient::all();
        return view('admin.discharges.edit', compact('discharge', 'patients'));
    }

    // Cập nhật dữ liệu
    public function update(Request $request, $patient_id, $discharge_date)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'discharge_date' => 'required|date',
        ]);

        $discharge = Discharge::where('patient_id', $patient_id)
            ->where('discharge_date', $discharge_date)
            ->firstOrFail();

        // Nếu có thay đổi khóa chính => xóa bản cũ và tạo mới
        if ($patient_id != $request->patient_id || $discharge_date != $request->discharge_date) {
            $discharge->delete();
            Discharge::create($request->only('patient_id', 'discharge_date'));
        } else {
            $discharge->update($request->only('patient_id', 'discharge_date'));
        }

        return redirect()->route('admin.discharges.index')->with('success', 'Cập nhật thành công');
    }

    // Xóa một bản ghi
    public function destroy($patient_id, $discharge_date)
    {
        Discharge::where('patient_id', $patient_id)
            ->where('discharge_date', $discharge_date)
            ->delete();

        return redirect()->route('admin.discharges.index')->with('success', 'Xóa thành công');
    }
}

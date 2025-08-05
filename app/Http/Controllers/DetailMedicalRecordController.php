<?php

namespace App\Http\Controllers;

use App\Models\DetailMedicalRecord;
use Illuminate\Http\Request;

class DetailMedicalRecordController extends Controller
{
    public function index()
    {
        $medicalDetails = DetailMedicalRecord::all();
        return view('admin.detail_medicalrecords.index', compact('medicalDetails'));
    }

    public function create()
    {
        return view('admin.detail_medicalrecords.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_id' => 'required|string',
            'patient_id' => 'required|string',
            'exam_date' => 'required|date',
            'prescription_id' => 'nullable|string',
            'disease_name' => 'nullable|string|max:40',
            'department_id' => 'required|string',
        ]);

        DetailMedicalRecord::create($validated);
        return redirect()->route('admin.detail-medicalrecords.index')->with('success', 'Thêm chi tiết SKB thành công');
    }

    public function edit($medical_record_id, $patient_id, $exam_date)
    {
        $record = DetailMedicalRecord::where('medical_record_id', $medical_record_id)
            ->where('patient_id', $patient_id)
            ->where('exam_date', $exam_date)
            ->firstOrFail();

        return view('admin.detail_medicalrecords.edit', ['detail' => $record]);

    }

    public function update(Request $request, $medical_record_id, $patient_id, $exam_date)
    {
        $record = DetailMedicalRecord::where('medical_record_id', $medical_record_id)
            ->where('patient_id', $patient_id)
            ->where('exam_date', $exam_date)
            ->firstOrFail();

        $validated = $request->validate([
            'prescription_id' => 'nullable|string',
            'disease_name' => 'nullable|string|max:40',
            'department_id' => 'required|string',
        ]);

        $record->update($validated);
        return redirect()->route('admin.detail-medicalrecords.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($medical_record_id, $patient_id, $exam_date)
    {
        $record = DetailMedicalRecord::where('medical_record_id', $medical_record_id)
            ->where('patient_id', $patient_id)
            ->where('exam_date', $exam_date)
            ->firstOrFail();

        $record->delete();
        return redirect()->route('admin.detail-medicalrecords.index')->with('success', 'Đã xóa chi tiết SKB');
    }
}

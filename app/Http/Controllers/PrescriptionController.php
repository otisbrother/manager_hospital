<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['doctor', 'patient'])->get();
        return view('admin.prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $doctors = Doctor::all();
        $patients = Patient::all();
        return view('admin.prescriptions.create', compact('doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:prescriptions,id',
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        Prescription::create($request->only(['id', 'doctor_id', 'patient_id']));

        return redirect()->route('admin.prescriptions.index')->with('success', 'Thêm đơn thuốc thành công');
    }

    public function show($id)
    {
        $prescription = Prescription::with(['doctor', 'patient', 'details.medicine'])->findOrFail($id);
        return view('admin.prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        $doctors = Doctor::all();
        $patients = Patient::all();
        return view('admin.prescriptions.edit', compact('prescription', 'doctors', 'patients'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $prescription->update($request->only(['doctor_id', 'patient_id']));

        return redirect()->route('admin.prescriptions.index')->with('success', 'Cập nhật đơn thuốc thành công');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('admin.prescriptions.index')->with('success', 'Xoá đơn thuốc thành công');
    }
}

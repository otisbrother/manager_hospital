<?php

namespace App\Http\Controllers;

use App\Models\Hospitalized;
use App\Models\Patient;
use Illuminate\Http\Request;

class HospitalizedController extends Controller
{
    public function index()
    {
        $hospitalizations = Hospitalized::with('patient')->get();
        return view('admin.hospitalized.index', compact('hospitalizations'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('admin.hospitalized.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'admission_date' => 'required|date',
            'room' => 'required|string|max:10',
            'bed' => 'required|integer|min:1',
        ]);

        Hospitalized::create($request->all());

        return redirect()->route('admin.hospitalized.index')->with('success', 'Thêm thông tin nhập viện thành công.');
    }

    public function edit($patient_id, $room, $bed)
    {
        $hospitalized = Hospitalized::where('patient_id', $patient_id)
                                    ->where('room', $room)
                                    ->where('bed', $bed)
                                    ->firstOrFail();
        $patients = Patient::all();
        return view('admin.hospitalized.edit', compact('hospitalized', 'patients'));
    }

    public function update(Request $request, $patient_id, $room, $bed)
    {
        $request->validate([
            'admission_date' => 'required|date',
            'bed' => 'required|integer|min:1',
        ]);

        $hospitalized = Hospitalized::where('patient_id', $patient_id)
                                    ->where('room', $room)
                                    ->where('bed', $bed)
                                    ->firstOrFail();

        $hospitalized->update([
            'admission_date' => $request->admission_date,
            'bed' => $request->bed,
        ]);

        return redirect()->route('admin.hospitalized.index')->with('success', 'Cập nhật nhập viện thành công.');
    }

    public function destroy($patient_id, $room, $bed)
    {
        Hospitalized::where('patient_id', $patient_id)
                    ->where('room', $room)
                    ->where('bed', $bed)
                    ->delete();

        return redirect()->route('admin.hospitalized.index')->with('success', 'Xoá thông tin nhập viện thành công.');
    }
}

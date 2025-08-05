<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('department')->get();
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:doctors,id|max:10',
            'name' => 'required|max:30',
            'gender' => 'nullable|max:5',
            'department_id' => 'required|exists:departments,id',
        ]);

        Doctor::create($request->all());

        return redirect()->route('admin.doctors.index')->with('success', 'Thêm bác sĩ thành công.');
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::all();
        return view('admin.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|max:30',
            'gender' => 'nullable|max:5',
            'department_id' => 'required|exists:departments,id',
        ]);

        $doctor->update($request->all());

        return redirect()->route('admin.doctors.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('admin.doctors.index')->with('success', 'Đã xoá bác sĩ.');
    }
}

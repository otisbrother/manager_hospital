<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypePatient;

class TypePatientController extends Controller
{
    public function index()
    {
        $types = TypePatient::all();
        return view('admin.type_patients.index', compact('types'));
    }

    public function create()
    {
        return view('admin.type_patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:type_patients,id|max:10',
            'name' => 'required|max:30',
        ]);

        TypePatient::create($request->only('id', 'name'));

        return redirect()->route('admin.type_patients.index')->with('success', 'Thêm thành công!');
    }

    public function edit($id)
    {
        $type = TypePatient::findOrFail($id);/*  */
        return view('admin.type_patients.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = TypePatient::findOrFail($id);
        $request->validate([
            'name' => 'required|max:30',
        ]);

        $type->update($request->only('name'));

        return redirect()->route('admin.type_patients.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        TypePatient::destroy($id);
        return redirect()->route('admin.type_patients.index')->with('success', 'Đã xóa!');
    }
}



?>
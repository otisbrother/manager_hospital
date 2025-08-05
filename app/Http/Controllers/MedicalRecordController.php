<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::orderBy('order')->get();
        return view('admin.medical_records.index', compact('records'));
    }

    public function show($id, $order)
    {
        $record = MedicalRecord::where('id', $id)->where('order', $order)->firstOrFail();
        return view('admin.medical_records.show', compact('record'));
    }

    public function create()
    {
        return view('admin.medical_records.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:30|unique:medical_records,id',
            'order' => 'required|integer|unique:medical_records,order',
        ]);

        MedicalRecord::create($request->only('id', 'order'));
        return redirect()->route('admin.medical-records.index')->with('success', 'Thêm thành công!');
    }

    public function edit($id, $order)
    {
        $record = MedicalRecord::where('id', $id)->where('order', $order)->firstOrFail();
        return view('admin.medical_records.edit', compact('record'));
    }

    public function update(Request $request, $id, $order)
    {
        $record = MedicalRecord::where('id', $id)->where('order', $order)->firstOrFail();

        $request->validate([
            'id' => 'required|string|max:30|unique:medical_records,id,' . $id . ',id',
            'order' => 'required|integer|unique:medical_records,order,' . $order . ',order',
        ]);

        $record->update($request->only('id', 'order'));
        return redirect()->route('admin.medical-records.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id, $order)
    {
        MedicalRecord::where('id', $id)->where('order', $order)->delete();
        return redirect()->route('admin.medical-records.index')->with('success', 'Xoá thành công!');
    }
}
?>
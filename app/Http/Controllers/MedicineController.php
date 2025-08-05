<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::all();
        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:10|unique:medicines,id',
            'name' => 'required|string|max:100',
            'usage' => 'nullable|string|max:200',
            'unit' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
        ]);

        Medicine::create($request->all());

        return redirect()->route('admin.medicines.index')->with('success', 'Thêm thuốc thành công');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'usage' => 'nullable|string|max:200',
            'unit' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
        ]);

        $medicine->update($request->all());

        return redirect()->route('admin.medicines.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Xoá thuốc thành công');
    }
}

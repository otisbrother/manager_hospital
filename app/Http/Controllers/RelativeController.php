<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Relative;
use Illuminate\Http\Request;

class RelativeController extends Controller
{
    public function index()
    {
        $relatives = Relative::all();
        return view('admin.relatives.index', compact('relatives'));
    }

    public function create()
    {
        return view('admin.relatives.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|string',
            'name' => 'required|string',
            'gender' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'relationship' => 'nullable|string|max:50',
        ]);

        Relative::create($validated);
        return redirect()->route('admin.relatives.index')->with('success', 'Thêm thân nhân thành công.');
    }

    public function show($patient_id, $name)
    {
        $relative = Relative::where('patient_id', $patient_id)
                            ->where('name', $name)
                            ->firstOrFail();

        return view('admin.relatives.show', compact('relative'));
    }

    public function edit($patient_id, $name)
    {
        $relative = Relative::where('patient_id', $patient_id)
                            ->where('name', $name)
                            ->firstOrFail();

        return view('admin.relatives.edit', compact('relative'));
    }

    public function update(Request $request, $patient_id, $name)
    {
        $relative = Relative::where('patient_id', $patient_id)
                            ->where('name', $name)
                            ->firstOrFail();

        $validated = $request->validate([
            'patient_id' => 'required|string',
            'name' => 'required|string',
            'gender' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'relationship' => 'nullable|string|max:50',
        ]);

        // Nếu thay đổi khóa chính → xóa bản cũ, tạo bản mới
        if ($relative->patient_id !== $validated['patient_id'] || $relative->name !== $validated['name']) {
            $relative->delete();
            Relative::create($validated);
        } else {
            $relative->update($validated);
        }

        return redirect()->route('admin.relatives.index')->with('success', 'Cập nhật thân nhân thành công.');
    }

    public function destroy($patient_id, $name)
    {
        // ✅ Truy vấn trực tiếp để tránh lỗi thiếu khóa chính
        Relative::where('patient_id', $patient_id)
                ->where('name', $name)
                ->delete();

        return redirect()->route('admin.relatives.index')->with('success', 'Đã xóa thân nhân.');
    }
}

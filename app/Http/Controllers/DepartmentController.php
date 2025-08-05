<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:10|unique:departments,id',
            'name' => 'required|string|max:30',
            'location' => 'nullable|string|max:30',
        ]);

        Department::create($request->only(['id', 'name', 'location']));

        return redirect()->route('admin.departments.index')->with('success', 'Thêm khoa thành công!');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'location' => 'nullable|string|max:30',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->only(['name', 'location']));

        return redirect()->route('admin.departments.index')->with('success', 'Cập nhật khoa thành công!');
    }

    public function destroy($id)
    {
        Department::destroy($id);
        return redirect()->route('admin.departments.index')->with('success', 'Đã xóa khoa!');
    }
}




?>
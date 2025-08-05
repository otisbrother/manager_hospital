@extends('layouts.app')

@section('content')
<div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
  <div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8 mt-8">
    <h2 class="text-2xl font-bold mb-6 text-purple-700 flex items-center gap-2">
        <i class="ph ph-user-plus"></i> Đăng ký thân nhân
    </h2>
    <form action="{{ route('patients.relatives.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="patient_id" value="{{ auth('patient')->user()->id ?? session('patient_id') }}">
        <div>
            <label class="block font-medium mb-1">Họ tên</label>
            <input type="text" name="name" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block font-medium mb-1">Giới tính</label>
            <select name="gender" required class="w-full border rounded px-3 py-2">
                <option value="">Chọn giới tính</option>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>
        <div>
            <label class="block font-medium mb-1">Ngày sinh</label>
            <input type="date" name="date_of_birth" required class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block font-medium mb-1">Quan hệ</label>
            <input type="text" name="relation" required class="w-full border rounded px-3 py-2" placeholder="VD: Mẹ, Bố, Anh, Chị, ...">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg">Lưu thân nhân</button>
        </div>
    </form>
</div>
</div>

@endsection
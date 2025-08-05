<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Chỉnh sửa: {{ $doctor->name }}</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Mã bác sĩ</label>
                    <input type="text" value="{{ $doctor->id }}" disabled
                           class="mt-1 block w-full bg-gray-100 rounded border-gray-300 shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Tên bác sĩ</label>
                    <input type="text" name="name" value="{{ old('name', $doctor->name) }}"
                           class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Giới tính</label>
                    <select name="gender" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        <option value="">-- Chọn --</option>
                        <option value="Nam" {{ old('gender', $doctor->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender', $doctor->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-gray-700">Khoa</label>
                    <select name="department_id"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                        <option value="">-- Chọn khoa --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ $doctor->department_id == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded shadow">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

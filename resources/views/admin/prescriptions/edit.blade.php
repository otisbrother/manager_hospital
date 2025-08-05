<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Chỉnh sửa đơn thuốc</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded p-6">
            <form action="{{ route('admin.prescriptions.update', $prescription->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700">Mã đơn thuốc</label>
                    <input type="text" name="id" value="{{ $prescription->id }}" class="form-input w-full" readonly>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Mã BS</label>
                    <select name="doctor_id" class="form-select w-full">
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ $prescription->doctor_id == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->doctor_id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Mã BN</label>
                    <select name="patient_id" class="form-select w-full">
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $prescription->patient_id == $patient->id ? 'selected' : '' }}>
                                {{ $patient->patient_id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-black px-4 py-2 rounded">Cập nhật</button>
                <a href="{{ route('admin.prescriptions.index') }}" class="ml-2 text-gray-600 hover:underline">Huỷ</a>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

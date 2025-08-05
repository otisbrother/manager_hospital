<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Thêm đơn thuốc</h2>
    </x-slot>
@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded p-6">
            <form action="{{ route('admin.prescriptions.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700">Mã đơn thuốc</label>
                    <input type="text" name="id" class="form-input w-full" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Mã BS</label>
                    <select name="doctor_id" class="form-select w-full">
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->doctor_id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Mã BN</label>
                    <select name="patient_id" class="form-select w-full">
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->patient_id }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded">Lưu</button>
                <a href="{{ route('admin.prescriptions.index') }}" class="ml-2 text-gray-600 hover:underline">Huỷ</a>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

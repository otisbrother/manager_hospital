<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            {{ __('Chi tiết bệnh nhân') }}
        </h2>
    </x-slot>
@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow p-6 rounded-lg">
                <p><strong>Mã BN:</strong> {{ $patient->id }}</p>
                <p><strong>Họ tên:</strong> {{ $patient->name }}</p>
                <p><strong>Giới tính:</strong> {{ $patient->gender }}</p>
                <p><strong>Ngày sinh:</strong> {{ $patient->date }}</p>
                <p><strong>Địa chỉ:</strong> {{ $patient->address }}</p>
                <p><strong>SĐT:</strong> {{ $patient->phone }}</p>
                <p><strong>Loại bệnh nhân:</strong> {{ $patient->typePatient->name ?? '-' }}</p>
                <p><strong>BHYT:</strong> {{ $patient->insurance->id ?? '-' }}</p>
            </div>

            <a href="{{ route('admin.patients.index') }}"
               class="inline-block mt-4 text-blue-600 hover:underline">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
       @endsection
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            📄 Chi tiết Thân nhân
        </h2>
    </x-slot>
    @section('content')
    <div class="py-6 px-6 bg-white rounded shadow space-y-3 text-sm">
        <p><strong>Mã bệnh nhân:</strong> {{ $relative->patient_id }}</p>
        <p><strong>Họ tên:</strong> {{ $relative->name }}</p>
        <p><strong>Giới tính:</strong> {{ $relative->gender }}</p>
        <p><strong>Ngày sinh:</strong> {{ \Carbon\Carbon::parse($relative->dob)->format('d/m/Y') }}</p>
        <p><strong>Quan hệ:</strong> {{ $relative->relationship }}</p>

        <a href="{{ url('admin/relatives') }}" class="text-blue-600 hover:underline">← Quay lại danh sách</a>
    </div>
    @endsection
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            🪪 Chi tiết Thẻ Bảo Hiểm Y Tế: {{ $insurance->id }}
        </h2>
    </x-slot>
    @section('content')
    <div class="py-6 px-6 bg-white rounded shadow space-y-4">
        <div>
            <strong class="text-gray-700">📌 Mã BHYT:</strong> {{ $insurance->id }}
        </div>
        <div>
            <strong class="text-gray-700">📅 Ngày đăng ký:</strong> {{ $insurance->register_date }}
        </div>
        <div>
            <strong class="text-gray-700">📅 Ngày hết hạn:</strong> {{ $insurance->expire_date }}
        </div>

        <div class="pt-4">
            <a href="{{ route('admin.insurances.index') }}" class="inline-block text-sm text-blue-600 hover:underline">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
    @endsection
</x-app-layout>

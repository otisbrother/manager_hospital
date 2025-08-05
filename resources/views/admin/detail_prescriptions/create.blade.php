<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Thêm Chi Tiết Đơn Thuốc</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 bg-white p-6 rounded shadow">
            <form action="{{ route('admin.detail-prescriptions.store') }}" method="POST">
                @csrf

                {{-- Mã đơn thuốc --}}
                <div class="mb-4">
                    <label for="prescription_id" class="block font-medium text-gray-700 mb-1">Mã đơn thuốc</label>
                    <select name="prescription_id" id="prescription_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="" disabled selected>-- Chọn đơn thuốc --</option>
                        @foreach($prescriptions as $prescription)
                            <option value="{{ $prescription->id }}">#{{ $prescription->id }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Mã thuốc --}}
                <div class="mb-4">
                    <label for="medicine_id" class="block font-medium text-gray-700 mb-1">Mã thuốc</label>
                    <select name="medicine_id" id="medicine_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="" disabled selected>-- Chọn thuốc --</option>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine->id }}">{{ $medicine->id }} - {{ $medicine->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Số lượng --}}
                <div class="mb-4">
                    <label for="quantity" class="block font-medium text-gray-700 mb-1">Số lượng</label>
                    <input type="number" name="quantity" id="quantity" min="1" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

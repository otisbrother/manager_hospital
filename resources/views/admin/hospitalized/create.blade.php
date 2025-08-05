<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Thêm thông tin nhập viện</h2>
    </x-slot>
    @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
    <div class="py-6">
        <div class="max-w-xl mx-auto px-4 bg-white p-6 rounded shadow">
            <form action="{{ route('admin.hospitalized.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Bệnh nhân</label>
                    <select name="patient_id" required class="w-full border rounded px-3 py-2">
                        <option value="" disabled selected>-- Chọn bệnh nhân --</option>
                        @foreach($patients as $p)
                            <option value="{{ $p->id }}">{{ $p->id }} - {{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Ngày nhập viện</label>
                    <input type="date" name="admission_date" required class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Phòng</label>
                    <input type="text" name="room" required class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Giường</label>
                    <input type="number" name="bed" min="1" required class="w-full border rounded px-3 py-2">
                </div>

                <div class="text-right">
                    <button class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded">Lưu</button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

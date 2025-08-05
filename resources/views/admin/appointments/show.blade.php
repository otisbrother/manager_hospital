<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-purple-700">
            📄 Chi tiết lịch hẹn #{{ $appointment->id }}
        </h2>
    </x-slot>
    @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
 <div class="p-6">
        <div class="bg-white shadow-lg rounded-lg p-6 space-y-4">

            <div>
                <h3 class="text-lg font-semibold text-gray-700">👤 Bệnh nhân</h3>
                <p class="text-gray-900">
                    {{ $appointment->patient->name ?? 'Không có thông tin' }} <br>
                    <span class="text-sm text-gray-500">ID: {{ $appointment->patient->id ?? 'N/A' }}</span>
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700">🧑‍⚕️ Bác sĩ</h3>
                <p class="text-gray-900">
                    {{ $appointment->doctor->name ?? 'Chưa phân công' }}
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700">🏥 Khoa khám</h3>
                <p class="text-gray-900">
                    {{ $appointment->department->name ?? 'Chưa rõ' }}
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700">📅 Ngày giờ hẹn</h3>
                <p class="text-gray-900">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700">📝 Triệu chứng</h3>
                <p class="text-gray-800 whitespace-pre-line">
                    {{ $appointment->symptoms }}
                </p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700">📌 Trạng thái</h3>
                <p class="text-sm font-semibold px-3 py-1 rounded 
                    {{ match($appointment->status) {
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'confirmed' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700'
                    } }}">
                    {{ ucfirst($appointment->status) }}
                </p>
            </div>

            @if ($appointment->notes)
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">🗒️ Ghi chú</h3>
                    <p class="text-gray-700 whitespace-pre-line">
                        {{ $appointment->notes }}
                    </p>
                </div>
            @endif

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.appointments.index') }}"
                   class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                    ← Quay lại danh sách
                </a>

                <a href="{{ route('admin.appointments.edit', $appointment->id) }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    ✏️ Chỉnh sửa
                </a>
            </div>
        </div>
    </div>
    </div>
   
    @endsection
</x-app-layout>

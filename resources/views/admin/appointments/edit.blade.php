<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-purple-700">✏️ Chỉnh sửa lịch hẹn #{{ $appointment->id }}</h2>
    </x-slot>
    @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
 <div class="p-6">
        <div class="bg-white shadow-lg rounded-lg p-6">
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 px-4 py-2 mb-4 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Chọn bệnh nhân --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bệnh nhân </label>
                        <select name="patient_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">-- Chọn bệnh nhân --</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->id }} - {{ $patient->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Chọn khoa --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Khoa khám</label>
                        <select name="department_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Chọn khoa --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ $appointment->department_id == $department->id ? 'selected' : '' }}>
                                    {{ $department->id }} - {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Chọn bác sĩ --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bác sĩ</label>
                        <select name="doctor_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Chọn bác sĩ --</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->id }} - {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Trạng thái --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Trạng thái </label>
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                </div>

                {{-- Ngày giờ hẹn --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ngày giờ hẹn </label>
                    <input type="datetime-local" name="appointment_date" 
                           value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                           required>
                </div>

                {{-- Triệu chứng --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700"> Triệu chứng </label>
                    <textarea name="symptoms" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                              placeholder="Mô tả triệu chứng của bệnh nhân..."
                              required>{{ $appointment->symptoms }}</textarea>
                </div>

                {{-- Ghi chú --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700"> Ghi chú</label>
                    <textarea name="notes" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                              placeholder="Ghi chú thêm (nếu có)...">{{ $appointment->notes }}</textarea>
                </div>

                {{-- Nút hành động --}}
                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('admin.appointments.index') }}" 
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                        ← Hủy
                    </a>
                    <button type="submit" 
                            class="bg-indigo-600 text-black px-6 py-2 rounded-md hover:bg-indigo-700">
                         Cập nhật 
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
   
   @endsection 
</x-app-layout> 
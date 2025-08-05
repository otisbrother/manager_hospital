<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✏️ Chỉnh sửa đơn thuốc {{ $prescription->id }} - Bác sĩ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    @include('doctors.partials.sidebar')

    <div class="lg:ml-64">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <i class="ph ph-list text-xl"></i>
                    </button>
                    <div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('doctors.prescriptions') }}" 
                               class="text-gray-500 hover:text-gray-700 transition-colors">
                                <i class="ph ph-arrow-left text-xl"></i>
                            </a>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">Chỉnh sửa đơn thuốc</h1>
                                <p class="text-gray-600">Mã đơn: <span class="font-mono font-medium">{{ $prescription->id }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if($errors->any())
            <div class="mx-6 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>
        @endif
        
        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <main class="p-6 max-w-4xl mx-auto">
            <form action="{{ route('doctors.prescription.update', $prescription->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Thông tin đơn thuốc -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-receipt text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Thông tin đơn thuốc</h2>
                            <p class="text-gray-600">Cập nhật thông tin kê đơn</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bệnh nhân</label>
                            <input type="text" value="{{ $prescription->patient->name ?? '' }}" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lịch tái khám</label>
                            <input type="date" name="next_appointment" value="{{ old('next_appointment', $prescription->next_appointment) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                            <textarea name="general_instructions" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('general_instructions', $prescription->general_instructions) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cảnh báo</label>
                            <textarea name="warnings" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('warnings', $prescription->warnings) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Chi tiết thuốc -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-pill text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Chi tiết thuốc</h2>
                            <p class="text-gray-600">Cập nhật danh sách thuốc trong đơn</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @foreach ($prescription->details as $i => $detail)
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tên thuốc</label>
                                    <select name="medicines[{{ $i }}][medicine_id]" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        @foreach ($medicines as $medicine)
                                            <option value="{{ $medicine->id }}" {{ $detail->medicine_id == $medicine->id ? 'selected' : '' }}>
                                                {{ $medicine->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Số lượng</label>
                                    <input type="number" name="medicines[{{ $i }}][quantity]" value="{{ $detail->quantity }}" min="1" max="100" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Số lượng">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Cách dùng</label>
                                    <input type="text" name="medicines[{{ $i }}][usage_instructions]" value="{{ $detail->usage_instructions }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Cách dùng">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium flex items-center gap-2 transition-colors">
                        <i class="ph ph-floppy-disk"></i>
                        Cập nhật đơn thuốc
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
        });

        document.getElementById('overlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('overlay').classList.add('hidden');
        });

        // Auto hide messages
        setTimeout(() => {
            const successMsg = document.querySelector('.bg-green-100');
            const errorMsg = document.querySelector('.bg-red-100');
            if (successMsg) successMsg.style.display = 'none';
            if (errorMsg) errorMsg.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>
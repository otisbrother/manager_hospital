<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👨‍⚕️ Thêm xuất viện mới - Bác sĩ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen font-sans text-gray-800 bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    @include('doctors.partials.sidebar')

    <!-- Mobile Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <i class="ph ph-list text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Thêm xuất viện mới</h1>
                        <p class="text-gray-600">Thêm thông tin xuất viện cho bệnh nhân</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6">
            <div class="max-w-2xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Thêm xuất viện mới</h1>
                    <a href="{{ route('doctors.discharges.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                        <i class="ph ph-arrow-left mr-2"></i>Quay lại
                    </a>
                </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('doctors.discharges.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Chọn bệnh nhân *
                    </label>
                    <select name="patient_id" id="patient_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Chọn bệnh nhân --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} (ID: {{ $patient->id }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Chỉ hiển thị bệnh nhân đã được khám và đang nhập viện</p>
                </div>

                <div class="mb-4">
                    <label for="discharge_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Ngày xuất viện *
                    </label>
                    <input type="date" name="discharge_date" id="discharge_date" required
                           value="{{ old('discharge_date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="discharge_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Lý do xuất viện *
                    </label>
                    <textarea name="discharge_reason" id="discharge_reason" rows="3" required
                              placeholder="Nhập lý do xuất viện..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('discharge_reason') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="treatment_result" class="block text-sm font-medium text-gray-700 mb-2">
                        Kết quả điều trị *
                    </label>
                    <textarea name="treatment_result" id="treatment_result" rows="3" required
                              placeholder="Nhập kết quả điều trị..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('treatment_result') }}</textarea>
                </div>

                <div class="mb-6">
                    <label for="follow_up_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                        Hướng dẫn theo dõi
                    </label>
                    <textarea name="follow_up_instructions" id="follow_up_instructions" rows="3"
                              placeholder="Nhập hướng dẫn theo dõi sau xuất viện..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('follow_up_instructions') }}</textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('doctors.discharges.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Hủy
                    </a>
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Thêm xuất viện
                    </button>
                </div>
            </form>
        </div>
            </div>
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        // Close sidebar when clicking overlay
        document.getElementById('overlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html> 
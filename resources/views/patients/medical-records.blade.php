<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Hồ sơ y tế - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="ph ph-file-text text-blue-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Hồ sơ y tế</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('patient.home') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-300">
                        <i class="ph ph-house"></i>
                        Trang chủ
                    </a>
                    
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Xin chào,</p>
                        <p class="font-semibold text-gray-800">{{ session('patient_name', 'Bệnh nhân') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Page Title -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">📋 Lịch sử khám bệnh</h2>
            <p class="text-gray-600">Xem lại thông tin các lần khám bệnh của bạn</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($medicalRecords->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="ph ph-file-text text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có hồ sơ khám bệnh</h3>
                <p class="text-gray-500 mb-6">Bạn chưa có lịch sử khám bệnh nào trong hệ thống.</p>
                <a href="{{ route('patient.appointment.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                    <i class="ph ph-calendar-plus"></i>
                    Đặt lịch khám
                </a>
            </div>
        @else
            <!-- Medical Records List -->
            <div class="space-y-6">
                @foreach ($medicalRecords as $record)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                                <div class="flex items-center gap-3 mb-2 sm:mb-0">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        Khám ngày {{ \Carbon\Carbon::parse($record->exam_date)->format('d/m/Y') }}
                                    </h3>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="ph ph-clock"></i>
                                    {{ \Carbon\Carbon::parse($record->exam_date)->diffForHumans() }}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Left Column -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <i class="ph ph-hospital text-blue-600"></i>
                                        <span class="text-sm text-gray-600">Khoa:</span>
                                        <span class="font-medium text-gray-800">
                                            {{ $record->department->name ?? 'N/A' }}
                                        </span>
                                    </div>
                                    
                                    @if ($record->disease_name)
                                        <div class="flex items-center gap-2">
                                            <i class="ph ph-bug text-red-600"></i>
                                            <span class="text-sm text-gray-600">Chẩn đoán:</span>
                                            <span class="font-medium text-gray-800">{{ $record->disease_name }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <i class="ph ph-clipboard text-green-600"></i>
                                        <span class="text-sm text-gray-600">Mã hồ sơ:</span>
                                        <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">
                                            {{ $record->medical_record_id }}
                                        </span>
                                    </div>
                                    
                                    @if ($record->prescription_id)
                                        <div class="flex items-center gap-2">
                                            <i class="ph ph-pill text-purple-600"></i>
                                            <span class="text-sm text-gray-600">Đơn thuốc:</span>
                                            <span class="font-mono text-sm bg-purple-100 px-2 py-1 rounded text-purple-800">
                                                {{ $record->prescription_id }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            @if ($record->prescription_id)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-gray-600">
                                            <i class="ph ph-info"></i>
                                            Có đơn thuốc kèm theo
                                        </p>
                                        <a href="{{ route('patients.prescriptions') }}" 
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded-lg transition-colors duration-300">
                                            <i class="ph ph-pill"></i>
                                            Xem đơn thuốc
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination or Load More can be added here -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Hiển thị {{ $medicalRecords->count() }} hồ sơ khám bệnh
                </p>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="mt-12 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Thao tác nhanh</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('patient.appointment.create') }}" 
                   class="flex items-center gap-3 p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-300">
                    <i class="ph ph-calendar-plus text-green-600 text-2xl"></i>
                    <div>
                        <p class="font-medium text-gray-800">Đặt lịch khám</p>
                        <p class="text-sm text-gray-600">Đặt lịch hẹn mới</p>
                    </div>
                </a>
                
                <a href="{{ route('patients.prescriptions') }}" 
                   class="flex items-center gap-3 p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-300">
                    <i class="ph ph-pill text-purple-600 text-2xl"></i>
                    <div>
                        <p class="font-medium text-gray-800">Đơn thuốc</p>
                        <p class="text-sm text-gray-600">Xem đơn thuốc</p>
                    </div>
                </a>
                
                <a href="{{ route('patients.bills') }}" 
                   class="flex items-center gap-3 p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors duration-300">
                    <i class="ph ph-receipt text-yellow-600 text-2xl"></i>
                    <div>
                        <p class="font-medium text-gray-800">Hóa đơn</p>
                        <p class="text-sm text-gray-600">Tra cứu hóa đơn</p>
                    </div>
                </a>
                
                <a href="{{ route('patients.hospitalization') }}" 
                   class="flex items-center gap-3 p-4 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-300">
                    <i class="ph ph-bed text-red-600 text-2xl"></i>
                    <div>
                        <p class="font-medium text-gray-800">Nhập viện</p>
                        <p class="text-sm text-gray-600">Lịch sử điều trị</p>
                    </div>
                </a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 Bệnh viện Heruko. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

</body>
</html>
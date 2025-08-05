<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Nhập/Xuất viện - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="ph ph-bed text-red-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Lịch sử điều trị nội trú</h1>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-2">🏥 Lịch sử nhập/xuất viện</h2>
            <p class="text-gray-600">Xem thông tin về các lần điều trị nội trú của bạn</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Tổng lần nhập viện</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $hospitalizations->count() }}</p>
                    </div>
                    <i class="ph ph-sign-in text-blue-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Đã xuất viện</p>
                        <p class="text-2xl font-bold text-green-600">{{ $discharges->count() }}</p>
                    </div>
                    <i class="ph ph-sign-out text-green-600 text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Đang nối trú</p>
                        <p class="text-2xl font-bold text-orange-600">
                            {{ $hospitalizations->count() - $discharges->count() }}
                        </p>
                    </div>
                    <i class="ph ph-user-focus text-orange-600 text-3xl"></i>
                </div>
            </div>
        </div>

        @if ($hospitalizations->isEmpty() && $discharges->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="ph ph-bed text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có lịch sử nhập viện</h3>
                <p class="text-gray-500 mb-6">Bạn chưa có thông tin về việc điều trị nội trú tại bệnh viện.</p>
                <a href="{{ route('patient.appointment.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-300">
                    <i class="ph ph-calendar-plus"></i>
                    Đặt lịch khám
                </a>
            </div>
        @else
            <!-- Timeline -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="ph ph-clock-clockwise text-blue-600"></i>
                    Timeline điều trị
                </h3>
                
                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-300"></div>
                    
                    <div class="space-y-8">
                        @php
                            // Kết hợp và sắp xếp dữ liệu theo thời gian
                            $events = collect();
                            
                            foreach ($hospitalizations as $hosp) {
                                $events->push([
                                    'type' => 'admission',
                                    'date' => $hosp->admission_date,
                                    'data' => $hosp
                                ]);
                            }
                            
                            foreach ($discharges as $discharge) {
                                $events->push([
                                    'type' => 'discharge',
                                    'date' => $discharge->discharge_date,
                                    'data' => $discharge
                                ]);
                            }
                            
                            $events = $events->sortByDesc('date');
                        @endphp
                        
                        @foreach ($events as $event)
                            <div class="relative flex items-start">
                                <!-- Timeline dot -->
                                <div class="flex-shrink-0 w-16 h-16 {{ $event['type'] === 'admission' ? 'bg-blue-100' : 'bg-green-100' }} rounded-full flex items-center justify-center relative z-10">
                                    @if ($event['type'] === 'admission')
                                        <i class="ph ph-sign-in text-blue-600 text-2xl"></i>
                                    @else
                                        <i class="ph ph-sign-out text-green-600 text-2xl"></i>
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="ml-6 flex-1">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        @if ($event['type'] === 'admission')
                                            <!-- Admission -->
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-lg font-semibold text-blue-800">
                                                    🏥 Nhập viện
                                                </h4>
                                                <span class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-sm text-gray-600">
                                                        <strong>Phòng:</strong> {{ $event['data']->room }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">
                                                        <strong>Giường:</strong> {{ $event['data']->bed }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">
                                                        <strong>Ngày nhập:</strong> 
                                                        {{ \Carbon\Carbon::parse($event['data']->admission_date)->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Discharge -->
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-lg font-semibold text-green-800">
                                                    🚪 Xuất viện
                                                </h4>
                                                <span class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 gap-2">
                                                <p class="text-sm text-gray-600">
                                                    <strong>Ngày xuất viện:</strong> 
                                                    {{ \Carbon\Carbon::parse($event['data']->discharge_date)->format('d/m/Y') }}
                                                </p>
                                                @if ($event['data']->diagnosis)
                                                    <p class="text-sm text-gray-600">
                                                        <strong>Chẩn đoán:</strong> {{ $event['data']->diagnosis }}
                                                    </p>
                                                @endif
                                                @if ($event['data']->treatment_result)
                                                    <p class="text-sm text-gray-600">
                                                        <strong>Kết quả điều trị:</strong> {{ $event['data']->treatment_result }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <!-- Duration calculation for admission -->
                                        @if ($event['type'] === 'admission')
                                            @php
                                                $discharge = $discharges->where('patient_id', $event['data']->patient_id)->first();
                                                if ($discharge) {
                                                    $days = \Carbon\Carbon::parse($event['data']->admission_date)
                                                        ->diffInDays(\Carbon\Carbon::parse($discharge->discharge_date));
                                                } else {
                                                    $days = \Carbon\Carbon::parse($event['data']->admission_date)->diffInDays(now());
                                                }
                                            @endphp
                                            <div class="mt-3 pt-3 border-t border-gray-200">
                                                <p class="text-sm text-gray-600">
                                                    <i class="ph ph-timer"></i>
                                                    Thời gian điều trị: 
                                                    <strong>{{ $days }} ngày</strong>
                                                    @if (!$discharge)
                                                        <span class="text-orange-600">(Đang điều trị)</span>
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            @if ($hospitalizations->isNotEmpty())
                <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="ph ph-list-bullets text-blue-600"></i>
                        Chi tiết nhập viện
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ngày nhập
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Phòng/Giường
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tình trạng
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Thời gian
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($hospitalizations as $hosp)
                                    @php
                                        $discharge = $discharges->where('patient_id', $hosp->patient_id)->first();
                                        $isActive = !$discharge;
                                        $duration = $discharge 
                                            ? \Carbon\Carbon::parse($hosp->admission_date)->diffInDays(\Carbon\Carbon::parse($discharge->discharge_date))
                                            : \Carbon\Carbon::parse($hosp->admission_date)->diffInDays(now());
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($hosp->admission_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Phòng {{ $hosp->room }} - Giường {{ $hosp->bed }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($isActive)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Đang điều trị
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Đã xuất viện
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $duration }} ngày
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif

        <!-- Quick Actions -->
        <div class="mt-12 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Thao tác nhanh</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('patients.medical-records') }}" 
                   class="flex items-center gap-3 p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-300">
                    <i class="ph ph-file-text text-blue-600 text-2xl"></i>
                    <div>
                        <p class="font-medium text-gray-800">Hồ sơ y tế</p>
                        <p class="text-sm text-gray-600">Xem lịch sử khám</p>
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
                
                <a href="{{ route('patient.appointment.create') }}" 
                   class="flex items-center gap-3 p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-300">
                    <i class="ph ph-calendar-plus text-green-600 text-2xl"></i>
                    <div>
                        <p class="font-medium text-gray-800">Đặt lịch khám</p>
                        <p class="text-sm text-gray-600">Khám bệnh mới</p>
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
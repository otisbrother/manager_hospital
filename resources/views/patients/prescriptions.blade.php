<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💊 Đơn thuốc - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="ph ph-pill text-purple-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Đơn thuốc của tôi</h1>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-2">💊 Danh sách đơn thuốc</h2>
            <p class="text-gray-600">Xem thông tin các đơn thuốc đã được kê cho bạn</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (request('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ request('success') }}</span>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-warning text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($prescriptions->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="ph ph-pill text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có đơn thuốc nào</h3>
                <p class="text-gray-500 mb-6">Bạn chưa có đơn thuốc nào được kê trong hệ thống.</p>
                <a href="{{ route('patient.appointment.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors duration-300">
                    <i class="ph ph-calendar-plus"></i>
                    Đặt lịch khám
                </a>
            </div>
        @else
            <!-- Prescriptions List -->
            <div class="space-y-6">
                @foreach ($prescriptions as $prescription)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <!-- Header -->
                        <div class="bg-purple-50 px-6 py-4 border-b border-purple-100">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center gap-3 mb-2 sm:mb-0">
                                    <i class="ph ph-clipboard-text text-purple-600 text-xl"></i>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            Đơn thuốc #{{ $prescription->id }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Bác sĩ: {{ $prescription->doctor->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="ph ph-calendar"></i>
                                    {{ $prescription->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            @if ($prescription->details && $prescription->details->count() > 0)
                                <!-- Medicine List -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                                        <i class="ph ph-list-bullets text-purple-600"></i>
                                        Danh sách thuốc ({{ $prescription->details->count() }} loại)
                                    </h4>
                                    
                                    <div class="grid gap-3">
                                        @foreach ($prescription->details as $detail)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                                        <i class="ph ph-pill text-purple-600 text-xl"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-medium text-gray-800">
                                                            {{ $detail->medicine->name ?? 'N/A' }}
                                                        </h5>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $detail->medicine->usage ?? 'Không có thông tin' }}
                                                        </p>
                                                        @if ($detail->medicine->unit)
                                                            <p class="text-xs text-gray-500">
                                                                Đơn vị: {{ $detail->medicine->unit }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <div class="text-lg font-bold text-purple-600">
                                                        {{ $detail->quantity ?? 0 }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">Số lượng</div>
                                                    @if ($detail->medicine->price)
                                                        <div class="text-sm text-gray-600 mt-1">
                                                            {{ number_format($detail->medicine->price * ($detail->quantity ?? 0), 0, ',', '.') }} VNĐ
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Usage Instructions -->
                                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                                    <h5 class="font-semibold text-blue-800 mb-2 flex items-center gap-2">
                                        <i class="ph ph-info"></i>
                                        Hướng dẫn sử dụng
                                    </h5>
                                    <ul class="text-sm text-blue-700 space-y-1">
                                        <li>• Uống thuốc đúng liều lượng theo chỉ định của bác sĩ</li>
                                        <li>• Uống thuốc đều đặn vào các thời điểm được chỉ định</li>
                                        <li>• Không tự ý tăng giảm liều lượng</li>
                                        <li>• Bảo quản thuốc ở nơi khô ráo, thoáng mát</li>
                                        <li>• Liên hệ bác sĩ nếu có tác dụng phụ</li>
                                    </ul>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="ph ph-pill text-gray-400 text-4xl mb-2"></i>
                                    <p class="text-gray-500">Đơn thuốc chưa có chi tiết</p>
                                </div>
                            @endif
                        </div>

                        <!-- Footer -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <i class="ph ph-clock"></i>
                                    Kê ngày: {{ $prescription->created_at->format('d/m/Y') }}
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">
                                        ✓ Đã kê
                                    </span>
                                    
                                    <!-- Nút Đặt thuốc -->
                                    <form action="{{ route('patient.order.medicine') }}" method="POST" class="inline" onsubmit="console.log('Form submitted for prescription: {{ $prescription->id }}')">
                                        @csrf
                                        <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">
                                        <button type="submit" 
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-300 text-sm font-medium">
                                            <i class="ph ph-shopping-cart"></i>
                                            Đặt thuốc
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Thống kê</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $prescriptions->count() }}</div>
                        <div class="text-sm text-gray-600">Tổng đơn thuốc</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">
                            {{ $prescriptions->sum(function($p) { return $p->details->count(); }) }}
                        </div>
                        <div class="text-sm text-gray-600">Tổng loại thuốc</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">
                            {{ $prescriptions->where('created_at', '>=', now()->subDays(30))->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Trong 30 ngày</div>
                    </div>
                </div>
            </div>
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
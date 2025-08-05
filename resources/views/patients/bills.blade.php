<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💰 Hóa đơn - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="ph ph-receipt text-yellow-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Tra cứu hóa đơn</h1>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-2">💰 Danh sách hóa đơn</h2>
            <p class="text-gray-600">Xem thông tin chi tiết về các hóa đơn thanh toán của bạn</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-warning-circle text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($bills->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="ph ph-receipt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có hóa đơn nào</h3>
                <p class="text-gray-500 mb-6">Bạn chưa có hóa đơn thanh toán nào trong hệ thống.</p>
                <a href="{{ route('patient.appointment.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors duration-300">
                    <i class="ph ph-calendar-plus"></i>
                    Đặt lịch khám
                </a>
            </div>
        @else
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Tổng hóa đơn</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $bills->count() }}</p>
                        </div>
                        <i class="ph ph-receipt text-yellow-600 text-3xl"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Tổng chi phí</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ number_format($bills->sum('total'), 0, ',', '.') }} VNĐ
                            </p>
                        </div>
                        <i class="ph ph-money text-green-600 text-3xl"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Có bảo hiểm</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $bills->whereNotNull('health_insurance_id')->count() }}
                            </p>
                        </div>
                        <i class="ph ph-shield-check text-blue-600 text-3xl"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Tháng này</p>
                            <p class="text-2xl font-bold text-purple-600">
                                {{ $bills->where('created_at', '>=', now()->startOfMonth())->count() }}
                            </p>
                        </div>
                        <i class="ph ph-calendar text-purple-600 text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Bills List -->
            <div class="space-y-6">
                @foreach ($bills as $bill)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                        <!-- Header -->
                        <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-100">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex items-center gap-3 mb-2 sm:mb-0">
                                    <i class="ph ph-file-text text-yellow-600 text-xl"></i>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            Hóa đơn #{{ $bill->id }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Ngày tạo: {{ $bill->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ number_format($bill->total, 0, ',', '.') }} VNĐ
                                    </div>
                                    <div class="text-sm text-gray-500">Tổng tiền</div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Left Column - Bill Details -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                                        <i class="ph ph-info text-blue-600"></i>
                                        Thông tin hóa đơn
                                    </h4>
                                    
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Mã hóa đơn:</span>
                                            <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">
                                                {{ $bill->id }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                            <span class="text-gray-600">Ngày tạo:</span>
                                            <span class="font-medium">
                                                {{ $bill->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                        
                                        @if ($bill->prescription_id)
                                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                                <span class="text-gray-600">Đơn thuốc:</span>
                                                <span class="font-mono text-sm bg-purple-100 px-2 py-1 rounded text-purple-800">
                                                    {{ $bill->prescription_id }}
                                                </span>
                                            </div>
                                            
                                            <!-- Chi tiết thuốc -->
                                            @if ($bill->prescription && $bill->prescription->details && $bill->prescription->details->count() > 0)
                                                <div class="mt-4 pt-4 border-t border-gray-200">
                                                    <h5 class="font-medium text-gray-800 mb-3">Chi tiết thuốc:</h5>
                                                    <div class="space-y-2">
                                                        @foreach ($bill->prescription->details as $detail)
                                                            <div class="flex items-center justify-between py-2 bg-gray-50 rounded px-3">
                                                                <div>
                                                                    <span class="font-medium">{{ $detail->medicine->name ?? 'N/A' }}</span>
                                                                    <span class="text-sm text-gray-600 ml-2">{{ $detail->quantity ?? 0 }} lượng</span>
                                                                </div>
                                                                <span class="text-sm font-medium text-green-600">
                                                                    {{ number_format(($detail->medicine->price ?? 0) * ($detail->quantity ?? 1), 0, ',', '.') }} VNĐ
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        
                                        <!-- Thông tin chi tiết về tiền -->
                                        @php
                                            $billCalculationService = new \App\Services\BillCalculationService();
                                            $originalAmount = 0;
                                            if ($bill->prescription) {
                                                foreach ($bill->prescription->details as $detail) {
                                                    $originalAmount += ($detail->medicine->price ?? 0) * ($detail->quantity ?? 1);
                                                }
                                            }
                                            $calculation = $billCalculationService->calculateBillWithInsurance($originalAmount, $patient);
                                        @endphp
                                        
                                        <div class="space-y-2 py-2">
                                            @if ($calculation['has_insurance'] && $calculation['insurance_amount'] > 0)
                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-600">Tổng tiền gốc:</span>
                                                    <span class="font-semibold text-gray-800">
                                                        {{ number_format($calculation['original_amount'], 0, ',', '.') }} VNĐ
                                                    </span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-blue-600">BHYT chi trả ({{ $calculation['insurance_percentage'] }}%):</span>
                                                    <span class="font-semibold text-blue-600">
                                                        -{{ number_format($calculation['insurance_amount'], 0, ',', '.') }} VNĐ
                                                    </span>
                                                </div>
                                                <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                                                    <span class="text-gray-600 font-semibold">Số tiền phải trả:</span>
                                                    <span class="text-xl font-bold text-green-600">
                                                        {{ number_format($calculation['patient_amount'], 0, ',', '.') }} VNĐ
                                                    </span>
                                                </div>
                                            @else
                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-600 font-semibold">Tổng tiền:</span>
                                                    <span class="text-xl font-bold text-green-600">
                                                        {{ number_format($bill->total, 0, ',', '.') }} VNĐ
                                                    </span>
                                                </div>
                                                @if ($calculation['has_insurance'] && $calculation['original_amount'] < 1000000)
                                                    <div class="text-sm text-orange-600 bg-orange-50 p-2 rounded">
                                                        <i class="ph ph-info"></i>
                                                        Số tiền dưới 1 triệu VNĐ nên không áp dụng bảo hiểm y tế
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        
                                        <!-- Nút thanh toán và xóa cho hóa đơn -->
                                        @if ($bill->status === 'pending')
                                            <div class="mt-4 pt-4 border-t border-gray-200">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-orange-600 font-medium">Trạng thái: Chờ thanh toán</span>
                                                    <div class="flex items-center gap-2">
                                                        <form action="{{ route('patient.pay.bill') }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                                            <button type="submit" 
                                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-300">
                                                                <i class="ph ph-credit-card"></i>
                                                                Thanh toán ngay
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('patient.delete.bill') }}" method="POST" class="inline" 
                                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                                                            <button type="submit" 
                                                                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-300">
                                                                <i class="ph ph-trash"></i>
                                                                Xóa hóa đơn
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($bill->status === 'paid')
                                            <div class="mt-4 pt-4 border-t border-gray-200">
                                                <div class="flex items-center gap-2 text-green-600">
                                                    <i class="ph ph-check-circle"></i>
                                                    <span class="font-medium">Đã thanh toán</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Right Column - Insurance Info -->
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                                        <i class="ph ph-shield-check text-blue-600"></i>
                                        Thông tin bảo hiểm
                                    </h4>
                                    
                                    @if ($patient->insurance_id)
                                        <div class="bg-blue-50 p-4 rounded-lg">
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-2">
                                                    <i class="ph ph-check-circle text-green-600"></i>
                                                    <span class="font-medium text-green-800">Có bảo hiểm y tế</span>
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    <strong>Mã thẻ BHYT:</strong> {{ $patient->insurance_id }}
                                                </div>
                                                @if ($patient->insurance)
                                                    <div class="text-sm text-gray-600">
                                                        <strong>Loại thẻ:</strong> {{ $patient->insurance->type ?? 'N/A' }}
                                                    </div>
                                                    <!-- @if ($patient->insurance->coverage_percentage)
                                                        <div class="text-sm text-gray-600">
                                                            <strong>Mức hưởng:</strong> {{ $patient->insurance->coverage_percentage }}%
                                                        </div>
                                                    @endif -->
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg-orange-50 p-4 rounded-lg">
                                            <div class="flex items-center gap-2">
                                                <i class="ph ph-warning text-orange-600"></i>
                                                <span class="font-medium text-orange-800">Không có bảo hiểm y tế</span>
                                            </div>
                                            <p class="text-sm text-orange-600 mt-1">
                                                Bệnh nhân tự thanh toán toàn bộ chi phí
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Prescription Details -->
                            @if ($bill->prescription && $bill->prescription->details && $bill->prescription->details->count() > 0)
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                        <i class="ph ph-pill text-purple-600"></i>
                                        Chi tiết đơn thuốc
                                    </h4>
                                    
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="space-y-3">
                                            @foreach ($bill->prescription->details as $detail)
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                                            <i class="ph ph-pill text-purple-600"></i>
                                                        </div>
                                                        <div>
                                                            <p class="font-medium text-gray-800">
                                                                {{ $detail->medicine->name ?? 'N/A' }}
                                                            </p>
                                                            <p class="text-sm text-gray-600">
                                                                Số lượng: {{ $detail->quantity ?? 0 }}
                                                                @if ($detail->medicine->unit)
                                                                    {{ $detail->medicine->unit }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    @if ($detail->medicine->price)
                                                        <div class="text-right">
                                                            <div class="font-semibold text-gray-800">
                                                                {{ number_format($detail->medicine->price * ($detail->quantity ?? 0), 0, ',', '.') }} VNĐ
                                                            </div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ number_format($detail->medicine->price, 0, ',', '.') }} VNĐ/đơn vị
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Footer -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <i class="ph ph-calendar"></i>
                                    Xuất hóa đơn: {{ $bill->created_at->format('d/m/Y') }}
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">
                                        ✓ Đã thanh toán
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">📊 Tổng quan chi phí</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Payment Summary -->
                    <div>
                        <h4 class="font-medium text-gray-800 mb-4">Thống kê thanh toán</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Tổng số hóa đơn:</span>
                                <span class="font-semibold">{{ $bills->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Tổng chi phí:</span>
                                <span class="font-semibold text-green-600">
                                    {{ number_format($bills->sum('total'), 0, ',', '.') }} VNĐ
                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Chi phí trung bình:</span>
                                <span class="font-semibold">
                                    {{ number_format($bills->avg('total'), 0, ',', '.') }} VNĐ
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Insurance Summary -->
                    <div>
                        <h4 class="font-medium text-gray-800 mb-4">Thống kê bảo hiểm</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="text-gray-600">Có BHYT:</span>
                                <span class="font-semibold text-blue-600">
                                    {{ $bills->whereNotNull('health_insurance_id')->count() }} hóa đơn
                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                                <span class="text-gray-600">Không BHYT:</span>
                                <span class="font-semibold text-orange-600">
                                    {{ $bills->whereNull('health_insurance_id')->count() }} hóa đơn
                                </span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600">Tỷ lệ có BHYT:</span>
                                <span class="font-semibold">
                                    {{ round(($bills->whereNotNull('health_insurance_id')->count() / $bills->count()) * 100, 1) }}%
                                </span>
                            </div>
                        </div>
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
                
                <a href="{{ route('patients.prescriptions') }}" 
                   class="flex items-center gap-3 p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-300">
                    <i class="ph ph-pill text-purple-600 text-2xl"></i>
                    <div>
                        <p class="font-medium text-gray-800">Đơn thuốc</p>
                        <p class="text-sm text-gray-600">Xem đơn thuốc</p>
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
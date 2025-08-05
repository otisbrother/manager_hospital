<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💊 Chi tiết đơn thuốc {{ $prescription->id }} - Bác sĩ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    @include('doctors.partials.sidebar')

    <!-- Main Content -->
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
                                <h1 class="text-2xl font-bold text-gray-800">Chi tiết đơn thuốc</h1>
                                <p class="text-gray-600">Mã đơn: <span class="font-mono font-medium">{{ $prescription->id }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('doctors.prescription.edit', $prescription->id) }}" 
                       class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="ph ph-pencil"></i>
                        Chỉnh sửa
                    </a>
                    
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="ph ph-printer"></i>
                        In đơn thuốc
                    </button>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('error'))
            <div class="mx-6 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Main Content -->
        <main class="p-6">
            <!-- Prescription Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="ph ph-receipt text-green-600 text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Thông tin đơn thuốc</h2>
                        <p class="text-gray-600">Chi tiết thông tin kê đơn</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column - Prescription Details -->
                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h3 class="text-sm font-medium text-blue-800 mb-3">Thông tin đơn thuốc</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Mã đơn thuốc (MADT):</span>
                                    <span class="font-mono font-medium text-gray-800">{{ $prescription->id }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Mã bác sĩ (MABS):</span>
                                    <span class="font-mono font-medium text-gray-800">{{ $prescription->doctor_id }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Mã bệnh nhân (MABN):</span>
                                    <span class="font-mono font-medium text-gray-800">{{ $prescription->patient_id }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Ngày kê đơn:</span>
                                    <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($prescription->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                
                                @if($prescription->updated_at != $prescription->created_at)
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Cập nhật lần cuối:</span>
                                        <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($prescription->updated_at)->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Patient Info -->
                    <div class="space-y-4">
                        @if($prescription->patient)
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <h3 class="text-sm font-medium text-purple-800 mb-3">Thông tin bệnh nhân</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Họ tên:</span>
                                        <span class="font-medium text-gray-800">{{ $prescription->patient->name ?? 'N/A' }}</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600">Mã bệnh nhân:</span>
                                        <span class="font-mono font-medium text-gray-800">{{ $prescription->patient->id ?? 'N/A' }}</span>
                                    </div>
                                    
                                    @if($prescription->patient->date_of_birth)
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600">Ngày sinh:</span>
                                            <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($prescription->patient->date_of_birth)->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($prescription->patient->phone)
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600">Số điện thoại:</span>
                                            <span class="font-medium text-gray-800">{{ $prescription->patient->phone }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($prescription->patient->address)
                                        <div class="pt-2 border-t border-purple-200">
                                            <span class="text-gray-600">Địa chỉ:</span>
                                            <p class="font-medium text-gray-800 mt-1">{{ $prescription->patient->address }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex items-center gap-2">
                                    <i class="ph ph-warning text-gray-400"></i>
                                    <span class="text-sm text-gray-600">Không tìm thấy thông tin bệnh nhân</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Medicine Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-pill text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Chi tiết thuốc</h2>
                            <p class="text-gray-600">Danh sách thuốc trong đơn</p>
                        </div>
                    </div>
                    
                    @if($prescription->details && $prescription->details->count() > 0)
                        <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $prescription->details->count() }} loại thuốc
                        </div>   
                    @endif
                </div>

                @if($prescription->details && $prescription->details->count() > 0)
                    <!-- Medicine List -->
                    <div class="space-y-4">
                        @foreach($prescription->details as $index => $detail)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-medium text-sm">
                                            {{ $index + 1 }}
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-800">
                                            {{ $detail->medicine->name ?? 'Tên thuốc không có' }}
                                        </h3>
                                    </div>
                                    
                                    <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $detail->quantity ?? 0 }} lượng
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div class="space-y-1">
                                        <span class="text-gray-600 block">Mã thuốc (MATHUOC):</span>
                                        <span class="font-mono font-medium text-gray-800">{{ $detail->medicine_id }}</span>
                                    </div>
                                    
                                    <div class="space-y-1">
                                        <span class="text-gray-600 block">Số lượng (SOLUONG):</span>
                                        <span class="font-medium text-gray-800">{{ $detail->quantity ?? 0 }} lượng</span>
                                    </div>
                                    
                                    @if($detail->medicine && $detail->medicine->unit)
                                        <div class="space-y-1">
                                            <span class="text-gray-600 block">Đơn vị:</span>
                                            <span class="font-medium text-gray-800">{{ $detail->medicine->unit }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($detail->medicine && $detail->medicine->description)
                                    <div class="mt-3 pt-3 border-t border-gray-100">
                                        <span class="text-gray-600 text-sm block mb-1">Mô tả thuốc:</span>
                                        <p class="text-gray-800 text-sm">{{ $detail->medicine->description }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Summary -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 font-medium">Tổng số loại thuốc:</span>
                                <span class="text-xl font-bold text-gray-800">{{ $prescription->details->count() }} loại</span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <i class="ph ph-pill text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-600 mb-2">Không có thuốc trong đơn</h3>
                        <p class="text-gray-500">Đơn thuốc này chưa có chi tiết thuốc nào.</p>
                    </div>
                @endif
            </div>
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

        // Print functionality
        document.querySelector('button:has(.ph-printer)')?.addEventListener('click', () => {
            window.print();
        });
    </script>
</body>
</html> 
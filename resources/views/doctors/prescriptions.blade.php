<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💊 Đơn thuốc của tôi - Bác sĩ</title>
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
                        <h1 class="text-2xl font-bold text-gray-800">Đơn thuốc của tôi</h1>
                        <p class="text-gray-600">Quản lý đơn thuốc đã kê cho bệnh nhân</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('doctors.prescription.create') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="ph ph-plus"></i>
                        Kê đơn mới
                    </a>
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
            <!-- Statistics Summary -->
            @if (!$prescriptions->isEmpty())
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="ph ph-pill text-green-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tổng đơn thuốc</p>
                                <p class="text-xl font-semibold text-gray-800">{{ $prescriptions->total() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="ph ph-calendar text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tháng này</p>
                                <p class="text-xl font-semibold text-gray-800">{{ $prescriptions->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="ph ph-users text-purple-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Bệnh nhân</p>
                                <p class="text-xl font-semibold text-gray-800">{{ $prescriptions->unique('patient_id')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="ph ph-clock text-orange-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Hôm nay</p>
                                <p class="text-xl font-semibold text-gray-800">{{ $prescriptions->where('created_at', '>=', today())->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($prescriptions->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <i class="ph ph-pill text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có đơn thuốc nào</h3>
                    <p class="text-gray-500 mb-6">Bạn chưa kê đơn thuốc nào cho bệnh nhân.</p>
                    <a href="{{ route('doctors.prescription.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-300">
                        <i class="ph ph-plus"></i>
                        Kê đơn thuốc mới
                    </a>
                </div>
            @else
                <!-- Prescriptions List -->
                <div class="space-y-6">
                    @foreach ($prescriptions as $prescription)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 overflow-hidden">
                            <div class="p-6">
                                <!-- Header -->
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-4">
                                    <div class="flex items-center gap-3 mb-2 lg:mb-0">
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            {{ $prescription->patient->name ?? 'N/A' }} - Đơn thuốc {{ $prescription->id }}
                                        </h3>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <span class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">{{ $prescription->id }}</span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Left Column - Patient & Prescription Info -->
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <i class="ph ph-user text-blue-600"></i>
                                            <span class="text-sm text-gray-600">Bệnh nhân:</span>
                                            <span class="font-medium text-gray-800">
                                                {{ $prescription->patient->name ?? 'N/A' }} 
                                                <span class="font-mono text-xs text-gray-500">({{ $prescription->patient_id }})</span>
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <i class="ph ph-calendar text-blue-600"></i>
                                            <span class="text-sm text-gray-600">Ngày kê:</span>
                                            <span class="font-medium text-gray-800">
                                                {{ \Carbon\Carbon::parse($prescription->created_at)->format('d/m/Y H:i') }}
                                                <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($prescription->created_at)->diffForHumans() }})</span>
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <i class="ph ph-identification-card text-blue-600"></i>
                                            <span class="text-sm text-gray-600">Mã đơn:</span>
                                            <span class="font-mono text-sm font-medium text-gray-800">{{ $prescription->id }}</span>
                                        </div>

                                        @if($prescription->patient && $prescription->patient->phone)
                                            <div class="flex items-center gap-2">
                                                <i class="ph ph-phone text-blue-600"></i>
                                                <span class="text-sm text-gray-600">SĐT:</span>
                                                <span class="font-medium text-gray-800">{{ $prescription->patient->phone }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Right Column - Medicine Details -->
                                    <div class="space-y-3">
                                        @if ($prescription->details && $prescription->details->count() > 0)
                                            <div class="bg-green-50 p-3 rounded-lg border border-green-200">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <i class="ph ph-pill text-green-600"></i>
                                                    <span class="text-sm font-medium text-green-800">Chi tiết thuốc ({{ $prescription->details->count() }} loại)</span>
                                                </div>
                                                
                                                <div class="space-y-1 text-sm max-h-32 overflow-y-auto">
                                                    @foreach($prescription->details as $detail)
                                                        <div class="flex items-center justify-between py-1 border-b border-green-100 last:border-b-0">
                                                            <span class="font-medium text-gray-800">{{ $detail->medicine->name ?? 'N/A' }}</span>
                                                            <span class="text-gray-600">{{ $detail->days ?? 0 }} ngày</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                <div class="flex items-center gap-2">
                                                    <i class="ph ph-warning text-gray-400"></i>
                                                    <span class="text-sm text-gray-600">Không có chi tiết thuốc</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Timestamps -->
                                        <div class="pt-3 border-t border-gray-100">
                                            <div class="text-xs text-gray-500 space-y-1">
                                                <div>Tạo lúc: {{ $prescription->created_at ? \Carbon\Carbon::parse($prescription->created_at)->format('d/m/Y H:i') : 'N/A' }}</div>
                                                @if($prescription->updated_at != $prescription->created_at)
                                                    <div>Cập nhật: {{ $prescription->updated_at ? \Carbon\Carbon::parse($prescription->updated_at)->format('d/m/Y H:i') : 'N/A' }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2 mt-6 pt-4 border-t border-gray-100">
                                    <a href="{{ route('doctors.prescription.view', $prescription->id) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                        <i class="ph ph-eye"></i>
                                        Xem chi tiết
                                    </a>
                                    
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
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $prescriptions->links() }}
                </div>
            @endif
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
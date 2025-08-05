<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 Hồ sơ bệnh nhân - Bác sĩ</title>
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
                        <h1 class="text-2xl font-bold text-gray-800">Hồ sơ bệnh nhân</h1>
                        <p class="text-gray-600">Xem hồ sơ y tế các bệnh nhân đã khám</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('doctors.exam.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="ph ph-plus"></i>
                        Khám bệnh mới
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
            @if (!$medicalRecords->isEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="ph ph-file-text text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tổng hồ sơ</p>
                                <p class="text-xl font-semibold text-gray-800">{{ $medicalRecords->total() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="ph ph-pill text-green-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Đã kê đơn</p>
                                <p class="text-xl font-semibold text-gray-800">{{ $medicalRecords->where('prescription_id', '!=', null)->count() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="ph ph-clock text-orange-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Chưa kê đơn</p>
                                <p class="text-xl font-semibold text-gray-800">{{ $medicalRecords->where('prescription_id', null)->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($medicalRecords->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <i class="ph ph-file-text text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có hồ sơ bệnh nhân</h3>
                    <p class="text-gray-500 mb-6">Bạn chưa có hồ sơ bệnh nhân nào để xem.</p>
                    <a href="{{ route('doctors.exam.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                        <i class="ph ph-stethoscope"></i>
                        Khám bệnh mới
                    </a>
                </div>
            @else
                <!-- Medical Records List -->
                <div class="space-y-6">
                    @foreach ($medicalRecords as $record)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 overflow-hidden">
                            <div class="p-6">
                                                                 <!-- Header -->
                                 <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-4">
                                     <div class="flex items-center gap-3 mb-2 lg:mb-0">
                                         <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                         <h3 class="text-lg font-semibold text-gray-800">
                                             {{ $record->patient->name ?? 'N/A' }} - Khám ngày {{ \Carbon\Carbon::parse($record->exam_date)->format('d/m/Y') }}
                                         </h3>
                                     </div>
                                     <div class="text-sm text-gray-500">
                                         <span class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">{{ $record->medical_record_id }}</span>
                                     </div>
                                 </div>

                                <!-- Content -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                                                         <!-- Left Column - Patient & Medical Info -->
                                     <div class="space-y-3">
                                         <div class="flex items-center gap-2">
                                             <i class="ph ph-identification-card text-blue-600"></i>
                                             <span class="text-sm text-gray-600">Mã hồ sơ:</span>
                                             <span class="font-mono text-sm font-medium text-gray-800">{{ $record->medical_record_id }}</span>
                                         </div>

                                         <div class="flex items-center gap-2">
                                             <i class="ph ph-user text-blue-600"></i>
                                             <span class="text-sm text-gray-600">Bệnh nhân:</span>
                                             <span class="font-medium text-gray-800">
                                                 {{ $record->patient->name ?? 'N/A' }} 
                                                 <span class="font-mono text-xs text-gray-500">({{ $record->patient_id }})</span>
                                             </span>
                                         </div>

                                         <div class="flex items-center gap-2">
                                             <i class="ph ph-calendar text-blue-600"></i>
                                             <span class="text-sm text-gray-600">Ngày khám:</span>
                                             <span class="font-medium text-gray-800">
                                                 {{ \Carbon\Carbon::parse($record->exam_date)->format('d/m/Y') }}
                                                 <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($record->exam_date)->diffForHumans() }})</span>
                                             </span>
                                         </div>

                                         <div class="flex items-center gap-2">
                                             <i class="ph ph-hospital text-blue-600"></i>
                                             <span class="text-sm text-gray-600">Khoa khám:</span>
                                             <span class="font-medium text-gray-800">
                                                 {{ $record->department->name ?? 'N/A' }}
                                                 <span class="font-mono text-xs text-gray-500">({{ $record->department_id }})</span>
                                             </span>
                                         </div>
                                         
                                         @if ($record->disease_name)
                                             <div class="flex items-center gap-2">
                                                 <i class="ph ph-bug text-red-600"></i>
                                                 <span class="text-sm text-gray-600">Chẩn đoán:</span>
                                                 <span class="font-medium text-gray-800">{{ $record->disease_name }}</span>
                                             </div>
                                         @else
                                             <div class="flex items-center gap-2">
                                                 <i class="ph ph-minus-circle text-gray-400"></i>
                                                 <span class="text-sm text-gray-500">Chưa có chẩn đoán</span>
                                             </div>
                                         @endif
                                     </div>

                                                                         <!-- Right Column - Prescription Info -->
                                     <div class="space-y-3">
                                         @if ($record->prescription_id && $record->prescription)
                                             <div class="bg-green-50 p-3 rounded-lg border border-green-200">
                                                 <div class="flex items-center gap-2 mb-2">
                                                     <i class="ph ph-pill text-green-600"></i>
                                                     <span class="text-sm font-medium text-green-800">Đã kê đơn thuốc</span>
                                                 </div>
                                                 
                                                 <div class="space-y-1 text-sm">
                                                     <div class="flex items-center gap-2">
                                                         <span class="text-gray-600">Mã đơn:</span>
                                                         <span class="font-mono font-medium text-gray-800">{{ $record->prescription_id }}</span>
                                                     </div>
                                                     
                                                     <div class="flex items-center gap-2">
                                                         <span class="text-gray-600">Ngày kê:</span>
                                                         <span class="font-medium text-gray-800">
                                                             {{ $record->prescription->created_at ? \Carbon\Carbon::parse($record->prescription->created_at)->format('d/m/Y H:i') : 'N/A' }}
                                                         </span>
                                                     </div>

                                                     @if($record->prescription->doctor)
                                                         <div class="flex items-center gap-2">
                                                             <span class="text-gray-600">Bác sĩ kê:</span>
                                                             <span class="font-medium text-gray-800">{{ $record->prescription->doctor->name ?? 'N/A' }}</span>
                                                         </div>
                                                     @endif
                                                 </div>
                                             </div>
                                         @elseif ($record->prescription_id && !$record->prescription)
                                             <div class="bg-orange-50 p-3 rounded-lg border border-orange-200">
                                                 <div class="flex items-center gap-2">
                                                     <i class="ph ph-warning text-orange-600"></i>
                                                     <span class="text-sm text-orange-800">
                                                         Đơn thuốc <span class="font-mono">{{ $record->prescription_id }}</span> không tìm thấy
                                                     </span>
                                                 </div>
                                             </div>
                                         @else
                                             <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                                 <div class="flex items-center gap-2">
                                                     <i class="ph ph-x-circle text-gray-400"></i>
                                                     <span class="text-sm text-gray-600">Chưa kê đơn thuốc</span>
                                                 </div>
                                                 <p class="text-xs text-gray-500 mt-1">Có thể kê đơn thuốc từ menu hành động bên dưới</p>
                                             </div>
                                         @endif

                                         <!-- Additional Medical Record Info -->
                                         <div class="pt-3 border-t border-gray-100">
                                             <div class="text-xs text-gray-500 space-y-1">
                                                 <div>Tạo lúc: {{ $record->created_at ? \Carbon\Carbon::parse($record->created_at)->format('d/m/Y H:i') : 'N/A' }}</div>
                                                 @if($record->updated_at != $record->created_at)
                                                     <div>Cập nhật: {{ $record->updated_at ? \Carbon\Carbon::parse($record->updated_at)->format('d/m/Y H:i') : 'N/A' }}</div>
                                                 @endif
                                             </div>
                                         </div>
                                     </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-2 mt-6 pt-4 border-t border-gray-100">
                                    <a href="{{ route('doctors.medical-record.view', $record->medical_record_id) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                        <i class="ph ph-eye"></i>
                                        Xem chi tiết
                                    </a>
                                    
                                    @if ($record->prescription)
                                        <a href="{{ route('doctors.prescription.view', $record->prescription->id) }}" 
                                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                            <i class="ph ph-pill"></i>
                                            Xem đơn thuốc
                                        </a>
                                        
                                        <a href="{{ route('doctors.prescription.edit', $record->prescription->id) }}" 
                                           class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                            <i class="ph ph-pencil"></i>
                                            Sửa đơn thuốc
                                        </a>
                                    @else
                                        <a href="{{ route('doctors.prescription.create', $record->medical_record_id) }}" 
                                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                            <i class="ph ph-plus"></i>
                                            Kê đơn thuốc
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $medicalRecords->links() }}
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
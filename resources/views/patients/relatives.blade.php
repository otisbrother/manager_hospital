<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👥 Thân nhân - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="ph ph-users-three text-teal-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Thông tin thân nhân</h1>
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
            <h2 class="text-3xl font-bold text-gray-800 mb-2">👥 Danh sách thân nhân</h2>
            <p class="text-gray-600">Thông tin về các thành viên trong gia đình và người thân của bạn</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('patients.relatives.create') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                <i class="ph ph-user-plus"></i>
                Thêm thân nhân
            </a>
        </div>

        @if ($relatives->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class="ph ph-users-three text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có thông tin thân nhân</h3>
                <p class="text-gray-500 mb-6">Hiện tại chưa có thông tin về thân nhân của bạn trong hệ thống.</p>
            </div>
        @else
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Tổng số thân nhân</p>
                            <p class="text-2xl font-bold text-teal-600">{{ $relatives->count() }}</p>
                        </div>
                        <i class="ph ph-users text-teal-600 text-3xl"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Nam</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $relatives->where('gender', 'Nam')->count() }}
                            </p>
                        </div>
                        <i class="ph ph-user text-blue-600 text-3xl"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Nữ</p>
                            <p class="text-2xl font-bold text-pink-600">
                                {{ $relatives->where('gender', 'Nữ')->count() }}
                            </p>
                        </div>
                        <i class="ph ph-user text-pink-600 text-3xl"></i>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Quan hệ khác nhau</p>
                            <p class="text-2xl font-bold text-purple-600">
                                {{ $relatives->unique('relationship')->count() }}
                            </p>
                        </div>
                        <i class="ph ph-tree-structure text-purple-600 text-3xl"></i>
                    </div>
                </div>
            </div>

            <!-- Relatives List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-teal-50 border-b border-teal-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="ph ph-address-book text-teal-600"></i>
                        Danh sách thân nhân
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="grid gap-4">
                        @foreach ($relatives as $relative)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-300">
                                <div class="flex items-start justify-between">
                                    <!-- Left side - Avatar and Info -->
                                    <div class="flex items-start gap-4">
                                        <!-- Avatar -->
                                        <div class="flex-shrink-0">
                                            <div class="w-16 h-16 rounded-full {{ $relative->gender === 'Nam' ? 'bg-blue-100' : 'bg-pink-100' }} flex items-center justify-center">
                                                @if ($relative->gender === 'Nam')
                                                    <i class="ph ph-user text-blue-600 text-2xl"></i>
                                                @else
                                                    <i class="ph ph-user text-pink-600 text-2xl"></i>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Info -->
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-800 mb-1">
                                                {{ $relative->name }}
                                            </h4>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-gray-600">
                                                <!-- Gender -->
                                                <div class="flex items-center gap-2">
                                                    <i class="ph ph-gender-{{ $relative->gender === 'Nam' ? 'male' : 'female' }} {{ $relative->gender === 'Nam' ? 'text-blue-600' : 'text-pink-600' }}"></i>
                                                    <span>{{ $relative->gender ?? 'Chưa cập nhật' }}</span>
                                                </div>
                                                
                                                <!-- Date of Birth -->
                                                @if ($relative->dob)
                                                    <div class="flex items-center gap-2">
                                                        <i class="ph ph-calendar text-gray-600"></i>
                                                        <span>
                                                            {{ \Carbon\Carbon::parse($relative->dob)->format('d/m/Y') }}
                                                            ({{ \Carbon\Carbon::parse($relative->dob)->age }} tuổi)
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="flex items-center gap-2">
                                                        <i class="ph ph-calendar text-gray-400"></i>
                                                        <span class="text-gray-400">Chưa có ngày sinh</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Right side - Relationship -->
                                    <div class="flex-shrink-0">
                                        @php
                                            $relationshipColors = [
                                                'Bố' => 'bg-blue-100 text-blue-800',
                                                'Mẹ' => 'bg-pink-100 text-pink-800',
                                                'Vợ' => 'bg-red-100 text-red-800',
                                                'Chồng' => 'bg-red-100 text-red-800',
                                                'Con' => 'bg-green-100 text-green-800',
                                                'Anh' => 'bg-purple-100 text-purple-800',
                                                'Chị' => 'bg-purple-100 text-purple-800',
                                                'Em' => 'bg-yellow-100 text-yellow-800',
                                                'Ông' => 'bg-gray-100 text-gray-800',
                                                'Bà' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $colorClass = $relationshipColors[$relative->relationship] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $colorClass }}">
                                            {{ $relative->relationship ?? 'Chưa rõ' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Additional Info -->
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <span>
                                            <i class="ph ph-clock"></i>
                                            Cập nhật: {{ $relative->updated_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Family Tree Visualization (Simple) -->
            <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="ph ph-tree-structure text-teal-600"></i>
                    Sơ đồ gia đình
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $relationshipGroups = $relatives->groupBy('relationship');
                    @endphp
                    
                    @foreach ($relationshipGroups as $relationship => $group)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-3 text-center">
                                {{ $relationship ?? 'Khác' }}
                            </h4>
                            
                            <div class="space-y-2">
                                @foreach ($group as $relative)
                                    <div class="flex items-center gap-3 p-2 bg-white rounded-lg">
                                        <div class="w-8 h-8 rounded-full {{ $relative->gender === 'Nam' ? 'bg-blue-100' : 'bg-pink-100' }} flex items-center justify-center">
                                            @if ($relative->gender === 'Nam')
                                                <i class="ph ph-user text-blue-600 text-sm"></i>
                                            @else
                                                <i class="ph ph-user text-pink-600 text-sm"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-800 text-sm">{{ $relative->name }}</p>
                                            @if ($relative->dob)
                                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($relative->dob)->age }} tuổi</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Info Notice -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <i class="ph ph-info text-blue-600 text-xl flex-shrink-0"></i>
                <div>
                    <h4 class="font-semibold text-blue-800 mb-2">Lưu ý quan trọng</h4>
                    <div class="text-sm text-blue-700 space-y-1">
                        <p>• Thông tin này được sử dụng để liên lạc trong trường hợp khẩn cấp</p>
                        <p>• Nếu có thay đổi thông tin thân nhân, vui lòng thông báo cho nhân viên y tế</p>
                        <p>• Tất cả thông tin thân nhân được bảo mật theo quy định của bệnh viện</p>
                    </div>
                </div>
            </div>
        </div>

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
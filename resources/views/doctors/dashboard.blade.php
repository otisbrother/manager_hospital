<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👨‍⚕️ Dashboard Bác sĩ - {{ $doctor->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                        <p class="text-gray-600">Chào mừng trở lại, BS. {{ $doctor->name }}!</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-600">{{ now()->format('l, d/m/Y') }}</p>
                        <p class="text-sm text-gray-500">{{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-6">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Today Appointments -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Lịch khám hôm nay</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['today_appointments'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-calendar-check text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Records -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Hồ sơ chờ khám</p>
                            <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_records'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-clock text-2xl text-orange-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Prescriptions -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Tổng đơn thuốc</p>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['total_prescriptions'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-pill text-2xl text-green-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Monthly Patients -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Bệnh nhân tháng này</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $stats['patients_this_month'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-users text-2xl text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hospitalization Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Current Hospitalizations -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Bệnh nhân đang nhập viện</p>
                            <p class="text-3xl font-bold text-indigo-600">{{ $stats['hospitalized_patients'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-bed text-2xl text-indigo-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Monthly Discharges -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Xuất viện tháng này</p>
                            <p class="text-3xl font-bold text-teal-600">{{ $stats['discharges_this_month'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-arrow-right text-2xl text-teal-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Monthly Hospitalizations -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Nhập viện tháng này</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['admissions_this_month'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-plus-circle text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Hospitalizations -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Tổng nhập viện</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $stats['total_admissions'] ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-buildings text-2xl text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Today's Appointments -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Lịch khám hôm nay</h3>
                            <a href="{{ route('doctors.appointments') }}" 
                               class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Xem tất cả →
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($todayAppointments->count() > 0)
                            <div class="space-y-4">
                                @foreach($todayAppointments as $appointment)
                                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-user text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800">{{ $appointment->patient->name }}</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') : 'N/A' }} - 
                                                {{ $appointment->symptoms ?? 'Không có triệu chứng' }}
                                            </p>
                                            <span class="inline-block px-2 py-1 bg-{{ $appointment->status === 'confirmed' ? 'blue' : 'green' }}-100 text-{{ $appointment->status === 'confirmed' ? 'blue' : 'green' }}-800 text-xs rounded-full mt-1">
                                                {{ $appointment->status === 'confirmed' ? 'Đã xác nhận' : 'Đang chờ' }}
                                            </span>
                                        </div>
                                        @if($appointment->status === 'confirmed')
                                            <a href="{{ route('doctors.exam.create', $appointment->id) }}" 
                                               class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                <i class="ph ph-stethoscope"></i>
                                            </a>
                                        @elseif($appointment->status === 'pending')
                                            <button disabled
                                                    class="px-3 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed opacity-60"
                                                    title="Cần chờ Admin xác nhận trước khi có thể khám bệnh">
                                                <i class="ph ph-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="ph ph-calendar-x text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500">Không có lịch khám nào hôm nay</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Patients -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Bệnh nhân gần đây</h3>
                            <a href="{{ route('doctors.medical-records') }}" 
                               class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Xem tất cả →
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($recentPatients->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentPatients as $record)
                                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-user-check text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800">{{ $record->patient->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $record->disease_name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($record->exam_date)->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                        <a href="{{ route('doctors.medical-record.view', $record->medical_record_id) }}" 
                                           class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                            <i class="ph ph-eye"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="ph ph-users text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500">Chưa có bệnh nhân nào</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Current Hospitalizations -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Bệnh nhân đang nhập viện</h3>
                            <a href="{{ route('doctors.hospitalized.index') }}" 
                               class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                Xem tất cả →
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if(isset($hospitalizedPatients) && $hospitalizedPatients->count() > 0)
                            <div class="space-y-4">
                                @foreach($hospitalizedPatients as $hospitalization)
                                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-bed text-indigo-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800">{{ $hospitalization->patient->name }}</h4>
                                            <p class="text-sm text-gray-600">Phòng: {{ $hospitalization->room }} - Giường: {{ $hospitalization->bed }}</p>
                                            <p class="text-xs text-gray-500">
                                                Nhập viện: {{ \Carbon\Carbon::parse($hospitalization->admission_date)->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <a href="{{ route('doctors.hospitalized.edit', [$hospitalization->patient_id, $hospitalization->room, $hospitalization->bed]) }}" 
                                           class="px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                            <i class="ph ph-pencil"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="ph ph-bed text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500">Không có bệnh nhân đang nhập viện</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                <a href="{{ route('doctors.exam.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl p-6 hover:from-blue-700 hover:to-blue-800 transition-all transform hover:scale-105">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="ph ph-stethoscope text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Khám bệnh mới</h3>
                            <p class="text-blue-100 text-sm">Tạo hồ sơ khám bệnh</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('doctors.prescription.create') }}" 
                   class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl p-6 hover:from-green-700 hover:to-green-800 transition-all transform hover:scale-105">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="ph ph-pill text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Kê đơn thuốc</h3>
                            <p class="text-green-100 text-sm">Tạo đơn thuốc mới</p>
                        </div>
                    </div>
                </a>

             
            </div>

            <!-- Recent Discharges Section -->
            <div class="mt-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Xuất viện gần đây</h3>
                            <a href="{{ route('doctors.discharges.index') }}" 
                               class="text-teal-600 hover:text-teal-700 text-sm font-medium">
                                Xem tất cả →
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if(isset($recentDischarges) && $recentDischarges->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($recentDischarges as $discharge)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                                                <i class="ph ph-arrow-right text-teal-600"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800">{{ $discharge->patient->name }}</h4>
                                                <p class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($discharge->discharge_date)->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Lý do:</span> {{ Str::limit($discharge->discharge_reason, 50) }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Kết quả:</span> {{ Str::limit($discharge->treatment_result, 50) }}
                                            </p>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('doctors.discharges.edit', [$discharge->patient_id, $discharge->discharge_date]) }}" 
                                               class="inline-flex items-center gap-1 text-teal-600 hover:text-teal-700 text-sm">
                                                <i class="ph ph-pencil"></i>
                                                <span>Chỉnh sửa</span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="ph ph-arrow-right text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500">Chưa có bệnh nhân xuất viện</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <a href="{{ route('doctors.statistics') }}" 
                   class="bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl p-6 hover:from-purple-700 hover:to-purple-800 transition-all transform hover:scale-105">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="ph ph-chart-bar text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Thống kê</h3>
                            <p class="text-purple-100 text-sm">Xem báo cáo chi tiết</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('doctors.hospitalized.index') }}" 
                   class="bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl p-6 hover:from-orange-700 hover:to-orange-800 transition-all transform hover:scale-105">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="ph ph-buildings text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Quản lý viện</h3>
                            <p class="text-orange-100 text-sm">Xem danh sách nhập/xuất viện</p>
                        </div>
                    </div>
                </a>
            </div>
        </main>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center gap-2">
                <i class="ph ph-x-circle text-xl"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        </div>
    @endif

    <script>
        // Enhanced sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const overlay = document.getElementById('overlay');

            // Sidebar toggle for mobile
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                    if (overlay) overlay.classList.toggle('hidden');
                });
            }

            // Overlay click to close sidebar
            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }

            // Auto hide messages
            setTimeout(() => {
                const successMsg = document.getElementById('success-message');
                const errorMsg = document.getElementById('error-message');
                if (successMsg) successMsg.style.display = 'none';
                if (errorMsg) errorMsg.style.display = 'none';
            }, 5000);

            // Enhanced logout confirmation
            window.confirmLogout = function() {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4 transform transition-all">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="ph ph-warning text-red-600 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Xác nhận đăng xuất</h3>
                        </div>
                        <p class="text-gray-600 mb-6">Bạn có chắc chắn muốn đăng xuất khỏi hệ thống?</p>
                        <div class="flex gap-3">
                            <button onclick="this.closest('.fixed').remove()" 
                                    class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                                Hủy
                            </button>
                            <button onclick="performLogout()" 
                                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                Đăng xuất
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                
                // Close modal when clicking outside
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.remove();
                    }
                });
            };

            // Perform logout
            window.performLogout = function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("doctor.logout") ?? "#" }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                document.body.appendChild(form);
                form.submit();
            };

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + B to toggle sidebar
                if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                    e.preventDefault();
                    if (sidebarToggle) {
                        sidebarToggle.click();
                    }
                }
                
                // Escape to close sidebar on mobile
                if (e.key === 'Escape' && window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    if (overlay) overlay.classList.add('hidden');
                }
            });

            // Update time every minute
            setInterval(() => {
                const now = new Date();
                const timeStr = now.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
                const timeElements = document.querySelectorAll('.current-time');
                timeElements.forEach(el => el.textContent = timeStr);
            }, 60000);

            // Add smooth scrolling for sidebar content
            const sidebarContent = sidebar.querySelector('.overflow-y-auto');
            if (sidebarContent) {
                sidebarContent.addEventListener('scroll', function() {
                    // Add shadow effect when scrolling
                    if (this.scrollTop > 0) {
                        this.style.boxShadow = 'inset 0 5px 5px -5px rgba(0,0,0,0.3)';
                    } else {
                        this.style.boxShadow = 'none';
                    }
                });
            }

            // Add hover effects for menu items
            const menuItems = sidebar.querySelectorAll('nav a');
            menuItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px) scale(1.02)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0) scale(1)';
                });
            });
        });
    </script>
</body>
</html>
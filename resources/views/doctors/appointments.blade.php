<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📅 Lịch khám - Bác sĩ</title>
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
                        <h1 class="text-2xl font-bold text-gray-800">Lịch khám của tôi</h1>
                        <p class="text-gray-600">Quản lý lịch khám đã được phân công</p>
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
            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm bệnh nhân</label>
                        <input type="text" id="searchPatient" placeholder="Nhập tên bệnh nhân..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                        <select id="statusFilter" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending">Đang chờ</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                        </select>
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ngày khám</label>
                        <input type="date" id="dateFilter" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Appointments List -->
            @if($appointments->count() > 0)
                <div class="space-y-4">
                    @foreach($appointments as $appointment)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 appointment-card" 
                             data-patient-name="{{ strtolower($appointment->patient->name) }}" 
                             data-status="{{ $appointment->status }}" 
                             data-date="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}">
                            
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                <!-- Patient Info -->
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="ph ph-user text-2xl text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $appointment->patient->name }}</h3>
                                        <div class="flex items-center gap-4 text-sm text-gray-600 mt-1">
                                            <span class="flex items-center gap-1">
                                                <i class="ph ph-calendar"></i>
                                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="ph ph-phone"></i>
                                                {{ $appointment->patient->phone ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600 mt-1">
                                            <span class="flex items-center gap-1">
                                                <i class="ph ph-note"></i>
                                                {{ $appointment->symptoms }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status & Actions -->
                                <div class="flex items-center gap-4">
                                    <!-- Status Badge -->
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        {{ match($appointment->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-blue-100 text-blue-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ match($appointment->status) {
                                            'pending' => 'Đang chờ',
                                            'confirmed' => 'Đã xác nhận',
                                            'completed' => 'Hoàn thành',
                                            'cancelled' => 'Đã hủy',
                                            default => 'Không rõ'
                                        } }}
                                    </span>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-2">
                                        @if($appointment->status === 'confirmed')
                                            <a href="{{ route('doctors.exam.create', $appointment->id) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                                <i class="ph ph-stethoscope"></i>
                                                Khám bệnh
                                            </a>
                                        @elseif($appointment->status === 'pending')
                                            <button disabled
                                                    class="bg-gray-400 cursor-not-allowed text-white px-4 py-2 rounded-lg flex items-center gap-2 opacity-60"
                                                    title="Cần chờ Admin xác nhận trước khi có thể khám bệnh">
                                                <i class="ph ph-lock"></i>
                                                Chờ xác nhận
                                            </button>
                                        @endif

                                        @if($appointment->status === 'completed')
                                            <a href="{{ route('doctors.medical-records') }}" 
                                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                                                <i class="ph ph-folder-open"></i>
                                                Xem hồ sơ
                                            </a>
                                        @endif

                                        <!-- Dropdown Menu -->
                                        <div class="relative">
                                            <button onclick="toggleDropdown('dropdown-{{ $appointment->id }}')" 
                                                    class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                                                <i class="ph ph-dots-three-vertical"></i>
                                            </button>
                                            <div id="dropdown-{{ $appointment->id }}" 
                                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-10">
                                                <div class="py-1">
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="ph ph-info mr-2"></i>
                                                        Xem chi tiết
                                                    </a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <i class="ph ph-phone mr-2"></i>
                                                        Gọi bệnh nhân
                                                    </a>
                                                    @if($appointment->status !== 'completed')
                                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                            <i class="ph ph-x mr-2"></i>
                                                            Hủy lịch
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            @if($appointment->notes)
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Ghi chú:</h4>
                                    <p class="text-sm text-gray-600">{{ $appointment->notes }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($appointments->hasPages())
                    <div class="mt-8">
                        {{ $appointments->links() }}
                    </div>
                @endif

            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12">
                    <div class="text-center">
                        <i class="ph ph-calendar-x text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có lịch khám nào</h3>
                        <p class="text-gray-600 mb-6">Bạn chưa được phân công lịch khám nào. Vui lòng liên hệ admin để được hỗ trợ.</p>
                        <a href="{{ route('doctors.dashboard') }}" 
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors">
                            <i class="ph ph-house"></i>
                            Về Dashboard
                        </a>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

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
        // Sidebar toggle for mobile
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
            const successMsg = document.getElementById('success-message');
            const errorMsg = document.getElementById('error-message');
            if (successMsg) successMsg.style.display = 'none';
            if (errorMsg) errorMsg.style.display = 'none';
        }, 5000);

        // Toggle dropdown
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
            
            // Close all other dropdowns
            allDropdowns.forEach(d => {
                if (d.id !== dropdownId) {
                    d.classList.add('hidden');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.relative')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
                    d.classList.add('hidden');
                });
            }
        });

        // Search and filter functionality
        const searchInput = document.getElementById('searchPatient');
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const appointmentCards = document.querySelectorAll('.appointment-card');

        function filterAppointments() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedStatus = statusFilter.value;
            const selectedDate = dateFilter.value;

            appointmentCards.forEach(card => {
                const patientName = card.dataset.patientName;
                const status = card.dataset.status;
                const date = card.dataset.date;

                const matchesSearch = !searchTerm || patientName.includes(searchTerm);
                const matchesStatus = !selectedStatus || status === selectedStatus;
                const matchesDate = !selectedDate || date === selectedDate;

                if (matchesSearch && matchesStatus && matchesDate) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            const visibleCards = Array.from(appointmentCards).filter(card => card.style.display !== 'none');
            const noResultsMsg = document.getElementById('no-results');
            
            if (visibleCards.length === 0 && appointmentCards.length > 0) {
                if (!noResultsMsg) {
                    const msg = document.createElement('div');
                    msg.id = 'no-results';
                    msg.className = 'bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center';
                    msg.innerHTML = `
                        <i class="ph ph-magnifying-glass text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Không tìm thấy kết quả</h3>
                        <p class="text-gray-600">Thử thay đổi bộ lọc để tìm thấy lịch khám bạn cần.</p>
                    `;
                    document.querySelector('main .space-y-4')?.appendChild(msg);
                }
            } else if (noResultsMsg) {
                noResultsMsg.remove();
            }
        }

        searchInput.addEventListener('input', filterAppointments);
        statusFilter.addEventListener('change', filterAppointments);
        dateFilter.addEventListener('change', filterAppointments);
    </script>
</body>
</html> 
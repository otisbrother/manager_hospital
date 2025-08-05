<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👨‍⚕️ Chi tiết hồ sơ khám - {{ $medicalRecord->patient->name ?? 'Bệnh nhân' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen font-sans text-gray-800 bg-gradient-to-br from-blue-50 to-indigo-100">

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
                        <h1 class="text-2xl font-bold text-gray-800">Chi tiết hồ sơ khám</h1>
                        <p class="text-gray-600">Thông tin chi tiết về hồ sơ khám bệnh</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('doctors.medical-records') }}" 
                       class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="ph ph-arrow-left"></i>
                        <span>Quay lại</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6">
            <!-- Patient Information Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="ph ph-user-circle text-blue-600"></i>
                        Thông tin bệnh nhân
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Họ và tên</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->patient->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Mã bệnh nhân</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->patient->id ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Ngày sinh</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->patient->birth_date ? \Carbon\Carbon::parse($medicalRecord->patient->birth_date)->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Giới tính</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->patient->gender ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Số điện thoại</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->patient->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Địa chỉ</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->patient->address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Record Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Medical Record Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                            <i class="ph ph-file-medical text-green-600"></i>
                            Thông tin khám bệnh
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Mã hồ sơ</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->medical_record_id ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Tên bệnh</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->disease_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Ngày khám</label>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $medicalRecord->exam_date ? \Carbon\Carbon::parse($medicalRecord->exam_date)->format('d/m/Y H:i') : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Khoa</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->department->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Thứ tự khám</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->order ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prescription Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                            <i class="ph ph-pill text-purple-600"></i>
                            Thông tin đơn thuốc
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($medicalRecord->prescription)
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Mã đơn thuốc</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->prescription->id ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Ngày kê đơn</label>
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ $medicalRecord->prescription->created_at ? \Carbon\Carbon::parse($medicalRecord->prescription->created_at)->format('d/m/Y H:i') : 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Bác sĩ kê đơn</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->prescription->doctor->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Số loại thuốc</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $medicalRecord->prescription->details->count() ?? 0 }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="ph ph-pill text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500">Chưa có đơn thuốc</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Prescription Details -->
            @if($medicalRecord->prescription && $medicalRecord->prescription->details->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mt-6">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                            <i class="ph ph-receipt text-orange-600"></i>
                            Chi tiết đơn thuốc
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">STT</th>
                                        <th scope="col" class="px-6 py-3">Tên thuốc</th>
                                        <th scope="col" class="px-6 py-3">Số lượng</th>
                                        <th scope="col" class="px-6 py-3">Đơn vị</th>
                                        <th scope="col" class="px-6 py-3">Cách dùng</th>
                                        <th scope="col" class="px-6 py-3">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicalRecord->prescription->details as $index => $detail)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4">{{ $detail->medicine->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4">{{ $detail->quantity ?? 'N/A' }}</td>
                                            <td class="px-6 py-4">{{ $detail->unit ?? 'N/A' }}</td>
                                            <td class="px-6 py-4">{{ $detail->usage_instructions ?? 'N/A' }}</td>
                                            <td class="px-6 py-4">{{ $detail->notes ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('doctors.medical-record.edit', $medicalRecord->medical_record_id) }}" 
                       class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="ph ph-pencil"></i>
                        <span>Chỉnh sửa</span>
                    </a>
                    
                    @if($medicalRecord->prescription)
                        <a href="{{ route('doctors.prescription.view', $medicalRecord->prescription->id) }}" 
                           class="flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="ph ph-eye"></i>
                            <span>Xem đơn thuốc</span>
                        </a>
                    @else
                        <a href="{{ route('doctors.prescription.create', $medicalRecord->medical_record_id) }}" 
                           class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="ph ph-plus"></i>
                            <span>Kê đơn thuốc</span>
                        </a>
                    @endif
                </div>

                <a href="{{ route('doctors.medical-records') }}" 
                   class="flex items-center gap-2 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="ph ph-arrow-left"></i>
                    <span>Quay lại danh sách</span>
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
        });
    </script>
</body>
</html> 
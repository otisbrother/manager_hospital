<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👨‍⚕️ Chỉnh sửa hồ sơ khám - {{ $medicalRecord->patient->name ?? 'Bệnh nhân' }}</title>
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
                        <h1 class="text-2xl font-bold text-gray-800">Chỉnh sửa hồ sơ khám</h1>
                        <p class="text-gray-600">Cập nhật thông tin hồ sơ khám bệnh</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('doctors.medical-record.view', $medicalRecord->medical_record_id) }}" 
                       class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="ph ph-arrow-left"></i>
                        <span>Quay lại</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6">
            <div class="max-w-4xl mx-auto">
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
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                            <i class="ph ph-pencil text-green-600"></i>
                            Chỉnh sửa thông tin khám bệnh
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('doctors.medical-record.update', $medicalRecord->medical_record_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="disease_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tên bệnh <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="disease_name" 
                                           name="disease_name" 
                                           value="{{ old('disease_name', $medicalRecord->disease_name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                           placeholder="Nhập tên bệnh"
                                           required>
                                    @error('disease_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="exam_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Ngày khám <span class="text-red-500">*</span>
                                    </label>
                                    <input type="datetime-local" 
                                           id="exam_date" 
                                           name="exam_date" 
                                           value="{{ old('exam_date', $medicalRecord->exam_date ? \Carbon\Carbon::parse($medicalRecord->exam_date)->format('Y-m-d\TH:i') : '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                           required>
                                    @error('exam_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="symptoms" class="block text-sm font-medium text-gray-700 mb-2">
                                        Triệu chứng
                                    </label>
                                    <textarea id="symptoms" 
                                              name="symptoms" 
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                              placeholder="Mô tả các triệu chứng của bệnh nhân">{{ old('symptoms', $medicalRecord->symptoms) }}</textarea>
                                    @error('symptoms')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">
                                        Chẩn đoán
                                    </label>
                                    <textarea id="diagnosis" 
                                              name="diagnosis" 
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                              placeholder="Chẩn đoán của bác sĩ">{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
                                    @error('diagnosis')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="treatment_plan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kế hoạch điều trị
                                    </label>
                                    <textarea id="treatment_plan" 
                                              name="treatment_plan" 
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                              placeholder="Kế hoạch điều trị cho bệnh nhân">{{ old('treatment_plan', $medicalRecord->treatment_plan) }}</textarea>
                                    @error('treatment_plan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Ghi chú
                                    </label>
                                    <textarea id="notes" 
                                              name="notes" 
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                              placeholder="Ghi chú bổ sung">{{ old('notes', $medicalRecord->notes) }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                                <a href="{{ route('doctors.medical-record.view', $medicalRecord->medical_record_id) }}" 
                                   class="flex items-center gap-2 px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    <i class="ph ph-x"></i>
                                    <span>Hủy</span>
                                </a>

                                <div class="flex items-center gap-4">
                                    <button type="submit" 
                                            class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="ph ph-check"></i>
                                        <span>Cập nhật</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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

            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const diseaseName = document.getElementById('disease_name').value.trim();
                    const examDate = document.getElementById('exam_date').value;
                    
                    if (!diseaseName) {
                        e.preventDefault();
                        alert('Vui lòng nhập tên bệnh');
                        return false;
                    }
                    
                    if (!examDate) {
                        e.preventDefault();
                        alert('Vui lòng chọn ngày khám');
                        return false;
                    }
                });
            }
        });
    </script>
</body>
</html> 
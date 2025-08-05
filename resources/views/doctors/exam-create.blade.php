<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Khám bệnh - Bác sĩ</title>
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
                        <h1 class="text-2xl font-bold text-gray-800">
                            @if($appointment)
                                Khám bệnh - {{ $appointment->patient->name }}
                            @else
                                Khám bệnh mới
                            @endif
                        </h1>
                        <p class="text-gray-600">Tạo hồ sơ khám bệnh và chẩn đoán</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('doctors.appointments') }}" 
                       class="text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="ph ph-arrow-left mr-2"></i>
                        Quay lại
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6">
            <!-- Error Messages -->
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="ph ph-warning text-red-600"></i>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('doctors.exam.store') }}" method="POST" class="max-w-4xl mx-auto">
                @csrf
                
                @if($appointment)
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                @endif

                <!-- Patient Info Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="ph ph-user text-blue-600"></i>
                        Thông tin bệnh nhân
                    </h2>

                    @if($appointment)
                        <!-- Pre-filled from appointment -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="font-medium text-blue-800 mb-2">Bệnh nhân</h3>
                                <p class="text-lg font-semibold text-gray-800">{{ $appointment->patient->name }}</p>
                                <p class="text-sm text-gray-600">ID: {{ $appointment->patient->id }}</p>
                                <p class="text-sm text-gray-600">SĐT: {{ $appointment->patient->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h3 class="font-medium text-green-800 mb-2">Lịch hẹn</h3>
                                <p class="text-sm text-gray-600">Ngày: {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-gray-600">Triệu chứng: {{ $appointment->symptoms }}</p>
                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full mt-1">
                                    {{ $appointment->status === 'confirmed' ? 'Đã xác nhận' : 'Đang chờ' }}
                                </span>
                            </div>
                        </div>
                    @else
                        <!-- Manual patient selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Chọn bệnh nhân <span class="text-red-500">*</span>
                                </label>
                                <select name="patient_id" id="patient_id" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Chọn bệnh nhân...</option>
                                    @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }} ({{ $patient->id }}) - {{ $patient->phone ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-sm text-gray-500 mt-2">
                                    <i class="ph ph-info text-blue-500"></i>
                                    Chỉ hiển thị bệnh nhân có lịch hẹn đã xác nhận hoặc không có lịch hẹn
                                </p>
                                @error('patient_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="patient-info" class="hidden bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-medium text-gray-800 mb-2">Thông tin bệnh nhân</h3>
                                <div id="patient-details" class="text-sm text-gray-600">
                                    Vui lòng chọn bệnh nhân để xem thông tin
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Exam Details Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="ph ph-stethoscope text-green-600"></i>
                        Thông tin khám bệnh
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="exam_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Ngày khám <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="exam_date" id="exam_date" required
                                   value="{{ $appointment ? \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') : old('exam_date', now()->format('Y-m-d\TH:i')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('exam_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Khoa khám
                            </label>
                            <input type="text" readonly 
                                   value="{{ Auth::guard('doctor')->user()->department->name ?? 'N/A' }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                            <p class="text-xs text-gray-500 mt-1">Khoa được xác định theo bác sĩ đăng nhập</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="disease_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Chẩn đoán bệnh <span class="text-red-500">*</span>
                        </label>
                        <textarea name="disease_name" id="disease_name" rows="4" required
                                  placeholder="Nhập chẩn đoán bệnh, tình trạng sức khỏe của bệnh nhân..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('disease_name') }}</textarea>
                        @error('disease_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="ph ph-info mr-1"></i>
                            Mô tả chi tiết tình trạng bệnh, triệu chứng, và chẩn đoán của bệnh nhân
                        </p>
                    </div>
                </div>

                <!-- Previous Medical History (if any) -->
                @if($appointment && $appointment->patient)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="ph ph-clock-counter-clockwise text-orange-600"></i>
                            Lịch sử khám bệnh
                        </h2>
                        
                        <div id="medical-history" class="space-y-3">
                            <p class="text-gray-600">Đang tải lịch sử khám bệnh...</p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex flex-col sm:flex-row gap-4 justify-between">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium flex items-center justify-center gap-2 transition-colors">
                                <i class="ph ph-floppy-disk"></i>
                                Lưu hồ sơ khám
                            </button>

                            <button type="button" onclick="saveAndPrescribe()" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium flex items-center justify-center gap-2 transition-colors">
                                <i class="ph ph-pill"></i>
                                Lưu và kê đơn thuốc
                            </button>
                        </div>

                        <div class="flex gap-4">
                            <button type="button" onclick="saveDraft()"
                                    class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-3 rounded-lg font-medium transition-colors">
                                <i class="ph ph-floppy-disk-back mr-2"></i>
                                Lưu nháp
                            </button>

                            <a href="{{ route('doctors.appointments') }}" 
                               class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-3 rounded-lg font-medium transition-colors">
                                <i class="ph ph-x mr-2"></i>
                                Hủy
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-medium text-blue-800 mb-2">Lưu ý:</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Sau khi lưu hồ sơ khám, bạn có thể tiếp tục kê đơn thuốc cho bệnh nhân</li>
                            <li>• Thông tin này sẽ được lưu vào hệ thống và bệnh nhân có thể xem trên trang cá nhân</li>
                            <li>• Đảm bảo thông tin chẩn đoán chính xác và đầy đủ</li>
                        </ul>
                    </div>
                </div>
            </form>
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

        // Patient selection handler
        @if(!$appointment)
        const patientSelect = document.getElementById('patient_id');
        const patientInfo = document.getElementById('patient-info');
        const patientDetails = document.getElementById('patient-details');

        patientSelect.addEventListener('change', function() {
            if (this.value) {
                // Show patient info (in real app, you'd fetch this via AJAX)
                const selectedOption = this.options[this.selectedIndex];
                const patientText = selectedOption.text;
                
                patientDetails.innerHTML = `
                    <p><strong>Tên:</strong> ${patientText.split(' (')[0]}</p>
                    <p><strong>ID:</strong> ${this.value}</p>
                    <p><strong>Trạng thái:</strong> <span class="text-green-600">Hoạt động</span></p>
                `;
                patientInfo.classList.remove('hidden');
            } else {
                patientInfo.classList.add('hidden');
            }
        });
        @endif

        // Load medical history (if appointment exists)
        @if($appointment)
        function loadMedicalHistory() {
            // In real app, this would be an AJAX call
            const historyDiv = document.getElementById('medical-history');
            
            // Simulated medical history
            historyDiv.innerHTML = `
                <div class="text-sm text-gray-600">
                    <p class="mb-2"><strong>Chưa có lịch sử khám bệnh trước đó</strong></p>
                    <p class="text-gray-500">Đây là lần khám đầu tiên của bệnh nhân tại bệnh viện.</p>
                </div>
            `;
        }
        
        // Load history when page loads
        document.addEventListener('DOMContentLoaded', loadMedicalHistory);
        @endif

        // Save and prescribe function
        function saveAndPrescribe() {
            // Add a hidden input to indicate we want to redirect to prescription form
            const form = document.querySelector('form');
            const redirectInput = document.createElement('input');
            redirectInput.type = 'hidden';
            redirectInput.name = 'redirect_to_prescription';
            redirectInput.value = '1';
            form.appendChild(redirectInput);
            
            form.submit();
        }

        // Save draft function
        function saveDraft() {
            if (confirm('Lưu bản nháp? Bạn có thể tiếp tục chỉnh sửa sau.')) {
                const form = document.querySelector('form');
                const draftInput = document.createElement('input');
                draftInput.type = 'hidden';
                draftInput.name = 'save_as_draft';
                draftInput.value = '1';
                form.appendChild(draftInput);
                
                form.submit();
            }
        }

        // Auto-save functionality (every 2 minutes)
        let autoSaveTimer;
        function startAutoSave() {
            autoSaveTimer = setInterval(() => {
                const formData = new FormData(document.querySelector('form'));
                formData.append('auto_save', '1');
                
                // In real app, this would be an AJAX call to save draft
                console.log('Auto-saving form data...');
            }, 120000); // 2 minutes
        }

        // Start auto-save when user starts typing
        document.getElementById('disease_name').addEventListener('input', function() {
            if (!autoSaveTimer) {
                startAutoSave();
            }
        });

        // Clear auto-save on form submit
        document.querySelector('form').addEventListener('submit', function() {
            if (autoSaveTimer) {
                clearInterval(autoSaveTimer);
            }
        });
    </script>
</body>
</html> 
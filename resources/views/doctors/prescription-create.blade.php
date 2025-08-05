<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💊 Kê đơn thuốc - Bác sĩ</title>
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
                            @if($medicalRecord)
                                Kê đơn thuốc - {{ $medicalRecord->patient->name }}
                            @else
                                Kê đơn thuốc mới
                            @endif
                        </h1>
                        <p class="text-gray-600">Tạo đơn thuốc và chỉ định cách sử dụng</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('doctors.prescriptions') }}" 
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

            <form action="{{ route('doctors.prescription.store') }}" method="POST" class="max-w-6xl mx-auto">
                @csrf
                
                @if($medicalRecord)
                    <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->medical_record_id }}">
                    <input type="hidden" name="patient_id" value="{{ $medicalRecord->patient_id }}">
                @endif

                <!-- Patient & Medical Record Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="ph ph-user text-blue-600"></i>
                        Thông tin bệnh nhân
                    </h2>

                    @if($medicalRecord)
                        <!-- From medical record -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="font-medium text-blue-800 mb-3">Thông tin bệnh nhân</h3>
                                <div class="space-y-2 text-sm">
                                    <p><strong>Tên:</strong> {{ $medicalRecord->patient->name }}</p>
                                    <p><strong>ID:</strong> {{ $medicalRecord->patient->id }}</p>
                                    <p><strong>Ngày sinh:</strong> {{ $medicalRecord->patient->date_of_birth ?? 'N/A' }}</p>
                                    <p><strong>SĐT:</strong> {{ $medicalRecord->patient->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h3 class="font-medium text-green-800 mb-3">Hồ sơ khám bệnh</h3>
                                <div class="space-y-2 text-sm">
                                    <p><strong>Mã hồ sơ:</strong> {{ $medicalRecord->medical_record_id }}</p>
                                    <p><strong>Ngày khám:</strong> {{ \Carbon\Carbon::parse($medicalRecord->exam_date)->format('d/m/Y H:i') }}</p>
                                    <p><strong>Chẩn đoán:</strong> {{ $medicalRecord->disease_name }}</p>
                                    <p><strong>Khoa:</strong> {{ $medicalRecord->department->name ?? 'N/A' }}</p>
                                </div>
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
                                            {{ $patient->name }} ({{ $patient->id }})
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

                <!-- Prescription Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                            <i class="ph ph-pill text-green-600"></i>
                            Danh sách thuốc
                        </h2>
                        <button type="button" onclick="addMedicine()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                            <i class="ph ph-plus"></i>
                            Thêm thuốc
                        </button>
                    </div>

                    <!-- Medicine List -->
                    <div id="medicine-list" class="space-y-4">
                        <!-- Medicine items will be added here -->
                    </div>

                    <!-- Template for medicine item (hidden) -->
                    <div id="medicine-template" class="hidden">
                        <div class="medicine-item border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-medium text-gray-800">Thuốc #<span class="medicine-number">1</span></h3>
                                <button type="button" onclick="removeMedicine(this)" 
                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tên thuốc <span class="text-red-500">*</span>
                                    </label>
                                    <select name="medicines[INDEX][medicine_id]" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Chọn thuốc...</option>
                                        @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}">
                                                {{ $medicine->name }} - {{ $medicine->unit ?? 'viên' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Số lượng <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="medicines[INDEX][quantity]" min="1" max="100"
                                           placeholder="Số lượng" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Cách sử dụng
                                </label>
                                <textarea name="medicines[INDEX][usage_instructions]" rows="2"
                                          placeholder="Ví dụ: Uống 2 viên mỗi ngày sau ăn, cách nhau 12 tiếng..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- No medicines message -->
                    <div id="no-medicines" class="text-center py-8 text-gray-500">
                        <i class="ph ph-pill text-4xl mb-4"></i>
                        <p>Chưa có thuốc nào được thêm</p>
                        <p class="text-sm">Nhấn "Thêm thuốc" để bắt đầu kê đơn</p>
                    </div>
                </div>

                <!-- Prescription Notes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="ph ph-note text-purple-600"></i>
                        Ghi chú đơn thuốc
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label for="general_instructions" class="block text-sm font-medium text-gray-700 mb-2">
                                Hướng dẫn chung
                            </label>
                            <textarea name="general_instructions" id="general_instructions" rows="3"
                                      placeholder="Ghi chú chung về cách sử dụng đơn thuốc..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('general_instructions') }}</textarea>
                        </div>

                        <div>
                            <label for="warnings" class="block text-sm font-medium text-gray-700 mb-2">
                                Cảnh báo & lưu ý
                            </label>
                            <textarea name="warnings" id="warnings" rows="2"
                                      placeholder="Những lưu ý đặc biệt, tác dụng phụ, cảnh báo..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('warnings') }}</textarea>
                        </div>

                        <div>
                            <label for="next_appointment" class="block text-sm font-medium text-gray-700 mb-2">
                                Lịch tái khám
                            </label>
                            <input type="date" name="next_appointment" id="next_appointment"
                                   min="{{ now()->addDays(1)->format('Y-m-d') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex flex-col sm:flex-row gap-4 justify-between">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-medium flex items-center justify-center gap-2 transition-colors">
                                <i class="ph ph-floppy-disk"></i>
                                Lưu đơn thuốc
                            </button>

                            <button type="button" onclick="previewPrescription()" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium flex items-center justify-center gap-2 transition-colors">
                                <i class="ph ph-eye"></i>
                                Xem trước
                            </button>
                        </div>

                        <div class="flex gap-4">
                            <button type="button" onclick="saveDraft()"
                                    class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-3 rounded-lg font-medium transition-colors">
                                <i class="ph ph-floppy-disk-back mr-2"></i>
                                Lưu nháp
                            </button>

                            <a href="{{ route('doctors.prescriptions') }}" 
                               class="border border-gray-300 text-gray-700 hover:bg-gray-50 px-6 py-3 rounded-lg font-medium transition-colors">
                                <i class="ph ph-x mr-2"></i>
                                Hủy
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-green-50 rounded-lg">
                        <h3 class="font-medium text-green-800 mb-2">Lưu ý khi kê đơn:</h3>
                        <ul class="text-sm text-green-700 space-y-1">
                            <li>• Kiểm tra kỹ tên thuốc, liều lượng và cách sử dụng</li>
                            <li>• Đảm bảo không có tương tác thuốc có hại</li>
                            <li>• Ghi rõ hướng dẫn sử dụng để bệnh nhân hiểu đúng</li>
                            <li>• Thông tin này sẽ được gửi đến bệnh nhân và nhà thuốc</li>
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
        let medicineIndex = 0;

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

        // Add medicine function
        function addMedicine() {
            const medicineList = document.getElementById('medicine-list');
            const template = document.getElementById('medicine-template');
            const noMedicinesMsg = document.getElementById('no-medicines');
            
            // Hide no medicines message
            noMedicinesMsg.style.display = 'none';
            
            // Clone template
            const newMedicine = template.cloneNode(true);
            newMedicine.id = '';
            newMedicine.classList.remove('hidden');
            
            // Update indices and IDs
            const html = newMedicine.innerHTML
                .replace(/INDEX/g, medicineIndex)
                .replace(/medicine-number">1/, `medicine-number">${medicineIndex + 1}`);
            newMedicine.innerHTML = html;
            
            // Add to list
            medicineList.appendChild(newMedicine);
            medicineIndex++;
            
            // Scroll to new medicine
            newMedicine.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Remove medicine function
        function removeMedicine(button) {
            if (confirm('Bạn có chắc chắn muốn xóa thuốc này?')) {
                const medicineItem = button.closest('.medicine-item');
                medicineItem.remove();
                
                // Show no medicines message if list is empty
                const medicineList = document.getElementById('medicine-list');
                const noMedicinesMsg = document.getElementById('no-medicines');
                
                if (medicineList.children.length === 0) {
                    noMedicinesMsg.style.display = 'block';
                } else {
                    // Update medicine numbers
                    const items = medicineList.querySelectorAll('.medicine-item');
                    items.forEach((item, index) => {
                        const numberSpan = item.querySelector('.medicine-number');
                        if (numberSpan) {
                            numberSpan.textContent = index + 1;
                        }
                    });
                }
            }
        }

        // Patient selection handler (for manual selection)
        @if(!$medicalRecord)
        const patientSelect = document.getElementById('patient_id');
        const patientInfo = document.getElementById('patient-info');
        const patientDetails = document.getElementById('patient-details');

        patientSelect.addEventListener('change', function() {
            if (this.value) {
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

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const medicineList = document.getElementById('medicine-list');
            if (medicineList.children.length === 0) {
                e.preventDefault();
                alert('Vui lòng thêm ít nhất một loại thuốc!');
                return false;
            }
            
            // Check if all medicines are properly filled
            let isValid = true;
            const medicineItems = medicineList.querySelectorAll('.medicine-item');
            
            medicineItems.forEach(item => {
                const medicineSelect = item.querySelector('select[name*="medicine_id"]');
                const quantityInput = item.querySelector('input[name*="quantity"]');
                
                if (!medicineSelect.value || !quantityInput.value) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin cho tất cả thuốc!');
                return false;
            }
        });

        // Preview prescription function
        function previewPrescription() {
            const medicineList = document.getElementById('medicine-list');
            if (medicineList.children.length === 0) {
                alert('Vui lòng thêm ít nhất một loại thuốc để xem trước!');
                return;
            }
            
            // In real app, this would open a modal with prescription preview
            alert('Tính năng xem trước đang được phát triển!');
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

        // Add first medicine by default
        document.addEventListener('DOMContentLoaded', function() {
            addMedicine();
        });
    </script>
</body>
</html> 
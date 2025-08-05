<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Đặt lịch khám - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>   
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="ph ph-hospital text-blue-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Bệnh viện Heruko</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('patient.home') }}" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-300">
                        <i class="ph ph-arrow-left"></i>
                        Quay lại
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Page Title -->
        <div class="text-center mb-8">
            <i class="ph ph-calendar-check text-green-600 text-6xl mb-4"></i>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Đặt lịch khám</h2>
            <p class="text-gray-600 text-lg">Vui lòng điền đầy đủ thông tin để đặt lịch hẹn với bác sĩ</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            
            <!-- Special Error for Doctor-Department Mismatch -->
            @if ($errors->has('doctor_department_mismatch'))
                <div class="mb-6 p-4 bg-red-100 border-2 border-red-500 text-red-700 rounded-lg shadow-md">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="ph ph-warning-circle text-red-600 text-xl"></i>
                        <h4 class="font-bold text-lg">Cảnh báo!</h4>
                    </div>
                    <p class="font-semibold">{{ $errors->first('doctor_department_mismatch') }}</p>
                </div>
            @endif

            <!-- Other Error Messages -->
            @if ($errors->any() && !$errors->has('doctor_department_mismatch'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <h4 class="font-semibold mb-2">Có lỗi xảy ra:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif ($errors->any() && $errors->has('doctor_department_mismatch'))
                @php
                    $otherErrors = $errors->except('doctor_department_mismatch');
                @endphp
                @if ($otherErrors->any())
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <h4 class="font-semibold mb-2">Có lỗi khác:</h4>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($otherErrors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif

            <form method="POST" action="{{ route('patient.appointment.store') }}" class="space-y-6">
                @csrf

                <!-- Patient Info Display -->
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center gap-2">
                        <i class="ph ph-user text-blue-600"></i>
                        Thông tin bệnh nhân
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Mã bệnh nhân:</span>
                            <span class="font-semibold ml-2">{{ session('patient_id') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Họ tên:</span>
                            <span class="font-semibold ml-2">{{ session('patient_name') }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Department Selection -->
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="ph ph-buildings mr-2 text-purple-600"></i>Khoa khám <span class="text-red-500">*</span>
                        </label>
                        <select id="department_id" name="department_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300">
                            <option value="">-- Chọn khoa --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->id }} - {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Doctor Selection -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="ph ph-stethoscope mr-2 text-blue-600"></i>Bác sĩ <span class="text-red-500">*</span>
                        </label>
                        <select id="doctor_id" name="doctor_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300">
                            <option value="">-- Chọn bác sĩ --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->id }} - {{ $doctor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- Appointment Date -->
                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ph ph-calendar mr-2 text-green-600"></i>Ngày và giờ hẹn <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" id="appointment_date" name="appointment_date" 
                        value="{{ old('appointment_date') }}" required
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Symptoms -->
                <div>
                    <label for="symptoms" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ph ph-clipboard-text mr-2 text-orange-600"></i>Triệu chứng <span class="text-red-500">*</span>
                    </label>
                    <textarea id="symptoms" name="symptoms" rows="4" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                        placeholder="Mô tả chi tiết triệu chứng và lý do khám bệnh...">{{ old('symptoms') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Tối đa 500 ký tự</p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4 justify-end pt-6">
                    <a href="{{ route('patient.home') }}" 
                        class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl transition-colors duration-300 flex items-center gap-2">
                        <i class="ph ph-x"></i>
                        Hủy
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl transition-colors duration-300 flex items-center gap-2">
                        <i class="ph ph-calendar-check"></i>
                        Đặt lịch hẹn
                    </button>
                </div>

            </form>
        </div>

        <!-- Notice -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center gap-2 text-yellow-800">
                <i class="ph ph-info text-xl"></i>
                <h4 class="font-semibold">Lưu ý quan trọng:</h4>
            </div>
            <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                <li>Lịch hẹn sẽ được xác nhận trong vòng 24 giờ làm việc</li>
                <li>Vui lòng đến đúng giờ hẹn, có mặt trước 15 phút</li>
                <li>Mang theo giấy tờ tùy thân và thẻ bảo hiểm y tế (nếu có)</li>
                <li>Liên hệ hotline: 1900-xxx-xxx nếu cần hỗ trợ</li>
            </ul>
        </div>

    </main>

    <!-- JavaScript for validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const departmentSelect = document.getElementById('department_id');
            const doctorSelect = document.getElementById('doctor_id');
            const form = document.querySelector('form');
            
            // Store all doctors with their department info
            const allDoctors = [
                @foreach($doctors as $doctor)
                {
                    id: '{{ $doctor->id }}',
                    name: '{{ $doctor->name }}',
                    department_id: '{{ $doctor->department_id }}',
                    department_name: '{{ optional($doctor->department)->name ?? "Chưa phân khoa" }}'
                },
                @endforeach
            ];

            // Function to filter doctors by department
            function filterDoctorsByDepartment() {
                const selectedDepartmentId = departmentSelect.value;
                
                // Clear current doctor options
                doctorSelect.innerHTML = '<option value="">-- Chọn bác sĩ --</option>';
                
                if (selectedDepartmentId) {
                    // Filter doctors by selected department
                    const filteredDoctors = allDoctors.filter(doctor => 
                        doctor.department_id === selectedDepartmentId
                    );
                    
                    // Add filtered doctors to select
                    filteredDoctors.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.id;
                        option.textContent = `${doctor.id} - ${doctor.name} - ${doctor.department_name}`;
                        doctorSelect.appendChild(option);
                    });
                    
                    // Show message if no doctors found
                    if (filteredDoctors.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Không có bác sĩ nào trong khoa này';
                        option.disabled = true;
                        doctorSelect.appendChild(option);
                    }
                } else {
                    // Show all doctors if no department selected
                    allDoctors.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.id;
                        option.textContent = `${doctor.id} - ${doctor.name} - ${doctor.department_name}`;
                        doctorSelect.appendChild(option);
                    });
                }
            }

            // Event listener for department change
            departmentSelect.addEventListener('change', filterDoctorsByDepartment);

            // Form validation before submit
            form.addEventListener('submit', function(e) {
                const selectedDepartmentId = departmentSelect.value;
                const selectedDoctorId = doctorSelect.value;
                
                if (selectedDepartmentId && selectedDoctorId) {
                    // Find selected doctor
                    const selectedDoctor = allDoctors.find(doctor => doctor.id === selectedDoctorId);
                    
                    // Check if doctor belongs to selected department
                    if (selectedDoctor && selectedDoctor.department_id !== selectedDepartmentId) {
                        e.preventDefault();
                        
                        // Show error message
                        showErrorMessage('Bạn đã chọn sai trường khoa hoặc bác sĩ. Vui lòng nhập lại.');
                        
                        // Scroll to top to show error
                        window.scrollTo({top: 0, behavior: 'smooth'});
                    }
                }
            });

            // Function to show error message
            function showErrorMessage(message) {
                // Remove existing error message if any
                const existingError = document.querySelector('.custom-error-message');
                if (existingError) {
                    existingError.remove();
                }
                
                // Create new error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'custom-error-message mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg';
                errorDiv.innerHTML = `
                    <h4 class="font-semibold mb-2">Có lỗi xảy ra:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <li>${message}</li>
                    </ul>
                `;
                
                // Insert error message at the beginning of form
                const form = document.querySelector('form');
                form.insertBefore(errorDiv, form.firstChild);
            }
        });
    </script>

</body>
</html> 
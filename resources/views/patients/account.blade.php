<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👤 Quản lý tài khoản - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="ph ph-user-circle text-indigo-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Quản lý tài khoản</h1>
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
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Page Title -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">👤 Thông tin tài khoản</h2>
            <p class="text-gray-600">Quản lý thông tin cá nhân và bảo mật tài khoản của bạn</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <i class="ph ph-warning-circle text-xl"></i>
                    <span class="font-semibold">Có lỗi xảy ra:</span>
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Account Information -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ph ph-address-book text-indigo-600"></i>
                    Thông tin cá nhân
                </h3>
            </div>
            
            <form action="{{ route('patients.account.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Patient ID (Read Only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-identifier"></i>
                                Mã bệnh nhân
                            </label>
                            <input type="text" value="{{ $patient->id }}" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                        </div>

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-user"></i>
                                Họ và tên *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $patient->name) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-phone"></i>
                                Số điện thoại
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-envelope"></i>
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $patient->email) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Gender (Read Only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-gender-intersex"></i>
                                Giới tính
                            </label>
                            <input type="text" value="{{ $patient->gender ?? 'Chưa cập nhật' }}" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="dob" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-calendar"></i>
                                Ngày sinh
                            </label>
                            <input type="date" id="dob" name="dob" value="{{ old('dob', $patient->date) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('dob')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Health Insurance ID -->
                        <div>
                            <label for="health_insurance_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-shield-check"></i>
                                Mã BHYT
                            </label>
                            <div class="flex gap-2">
                                <input type="text" id="health_insurance_id" name="health_insurance_id" value="{{ old('health_insurance_id', $patient->insurance_id) }}"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Nhập mã thẻ BHYT">
                                <button type="button" 
                                        onclick="openSupportLevelModal()"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <i class="ph ph-plus"></i>
                                </button>
                            </div>
                            
                            <!-- Trạng thái BHYT -->
                            @if($patient->latestInsuranceApplication)
                                <div class="mt-2 p-3 rounded-lg border
                                    @if($patient->latestInsuranceApplication->status == 'pending') bg-yellow-50 border-yellow-200
                                    @elseif($patient->latestInsuranceApplication->status == 'approved') bg-green-50 border-green-200
                                    @else bg-red-50 border-red-200
                                    @endif">
                                    <div class="flex items-center gap-2">
                                        @if($patient->latestInsuranceApplication->status == 'pending')
                                            <i class="ph ph-clock text-yellow-600"></i>
                                            <span class="text-sm text-yellow-800">⏳ Chờ duyệt</span>
                                        @elseif($patient->latestInsuranceApplication->status == 'approved')
                                            <i class="ph ph-check-circle text-green-600"></i>
                                            <span class="text-sm text-green-800">✅ Đã duyệt bởi admin</span>
                                        @else
                                            <i class="ph ph-x-circle text-red-600"></i>
                                            <span class="text-sm text-red-800">❌ Bị từ chối</span>
                                        @endif
                                    </div>
                                    @if($patient->latestInsuranceApplication->admin_notes)
                                        <p class="text-xs text-gray-600 mt-1">{{ $patient->latestInsuranceApplication->admin_notes }}</p>
                                    @endif
                                </div>
                            @else
                                <div class="mt-2">
                                    <a href="{{ route('insurance-applications.create') }}" 
                                       class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">
                                        <i class="ph ph-plus"></i>
                                        Đăng ký hỗ trợ viện phí
                                    </a>
                                </div>
                            @endif
                            
                            @error('health_insurance_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type Patient (Read Only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-tag"></i>
                                Loại bệnh nhân
                            </label>
                            <input type="text" value="{{ $patient->typePatient->name ?? 'Chưa phân loại' }}" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="ph ph-map-pin"></i>
                                Địa chỉ
                            </label>
                            <textarea id="address" name="address" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $patient->address) }}</textarea>
                            @error('address')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-300">
                        <i class="ph ph-floppy-disk"></i>
                        Cập nhật thông tin
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-red-50 px-6 py-4 border-b border-red-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="ph ph-lock text-red-600"></i>
                    Đổi mật khẩu
                </h3>
            </div>
            
            <form action="{{ route('patients.account.change-password') }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-4 max-w-md">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="ph ph-lock"></i>
                            Mật khẩu hiện tại *
                        </label>
                        <input type="password" id="current_password" name="current_password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('current_password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="ph ph-key"></i>
                            Mật khẩu mới *
                        </label>
                        <input type="password" id="new_password" name="new_password" required minlength="6"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <p class="text-gray-500 text-xs mt-1">Mật khẩu phải có ít nhất 6 ký tự</p>
                        @error('new_password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="ph ph-key"></i>
                            Xác nhận mật khẩu mới *
                        </label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required minlength="6"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('new_password_confirmation')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-300">
                        <i class="ph ph-shield-check"></i>
                        Đổi mật khẩu
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Statistics -->
        <div class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                <i class="ph ph-chart-bar text-indigo-600"></i>
                Thống kê tài khoản
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <i class="ph ph-calendar-plus text-blue-600 text-3xl mb-2"></i>
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $patient->created_at->format('d/m/Y') }}
                    </div>
                    <div class="text-sm text-gray-600">Ngày đăng ký</div>
                </div>
                
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <i class="ph ph-clock text-green-600 text-3xl mb-2"></i>
                    <div class="text-2xl font-bold text-green-600">
                        {{ $patient->created_at->diffInDays(now()) }}
                    </div>
                    <div class="text-sm text-gray-600">Ngày thành viên</div>
                </div>
                
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <i class="ph ph-clock-clockwise text-purple-600 text-3xl mb-2"></i>
                    <div class="text-2xl font-bold text-purple-600">
                        {{ $patient->updated_at->format('d/m/Y') }}
                    </div>
                    <div class="text-sm text-gray-600">Cập nhật cuối</div>
                </div>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <div class="flex items-start gap-3">
                <i class="ph ph-shield-warning text-yellow-600 text-xl flex-shrink-0"></i>
                <div>
                    <h4 class="font-semibold text-yellow-800 mb-2">Lưu ý bảo mật</h4>
                    <div class="text-sm text-yellow-700 space-y-1">
                        <p>• Không chia sẻ thông tin đăng nhập với người khác</p>
                        <p>• Sử dụng mật khẩu mạnh và thay đổi định kỳ</p>
                        <p>• Luôn đăng xuất sau khi sử dụng trên máy tính chung</p>
                        <p>• Liên hệ nhân viên y tế nếu phát hiện bất thường</p>
                        <p>• Một số thông tin cá nhân chỉ có thể được cập nhật bởi nhân viên y tế</p>
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

    <!-- Password Strength Indicator Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');
            
            // Password matching validation
            confirmPasswordInput.addEventListener('input', function() {
                if (this.value !== newPasswordInput.value) {
                    this.setCustomValidity('Mật khẩu không khớp');
                } else {
                    this.setCustomValidity('');
                }
            });
            
            newPasswordInput.addEventListener('input', function() {
                if (confirmPasswordInput.value && confirmPasswordInput.value !== this.value) {
                    confirmPasswordInput.setCustomValidity('Mật khẩu không khớp');
                } else {
                    confirmPasswordInput.setCustomValidity('');
                }
            });
        });
    </script>

</body>
</html>
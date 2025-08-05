<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Đăng ký - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>   
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gradient-to-br from-blue-200 via-purple-100 to-pink-200 min-h-screen py-8 px-4 font-sans">

    <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2 flex items-center justify-center gap-2">
                <i class="ph ph-user-plus text-green-600 text-4xl"></i> 
                Đăng ký Bệnh nhân
            </h1>
            <p class="text-gray-600">Vui lòng nhập đầy đủ thông tin để đăng ký</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Form -->
        <form method="POST" action="{{ route('patient.register') }}" class="space-y-6">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="ph ph-user mr-2"></i>Họ và tên <span class="text-red-500">*</span>
                </label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                    placeholder="Nhập họ và tên đầy đủ" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="ph ph-envelope mr-2"></i>Gmail <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                    placeholder="Nhập email của bạn" required>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ph ph-lock mr-2"></i>Mật khẩu <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                        placeholder="Nhập mật khẩu" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ph ph-lock mr-2"></i>Xác nhận mật khẩu <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                        placeholder="Nhập lại mật khẩu" required>
                </div>
            </div>

            <!-- Insurance Code -->
            <div>
                <label for="insurance_code" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="ph ph-card mr-2"></i>Mã BHYT
                </label>
                <input type="text" id="insurance_code" name="insurance_code" value="{{ old('insurance_code') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                    placeholder="Nhập mã bảo hiểm y tế (nếu có)">
            </div>

            <!-- Gender and Date of Birth -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ph ph-gender-intersex mr-2"></i>Giới tính <span class="text-red-500">*</span>
                    </label>
                    <select id="gender" name="gender" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" required>
                        <option value="">Chọn giới tính</option>
                        <option value="Nam" {{ old('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="ph ph-calendar mr-2"></i>Ngày sinh <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" required>
                </div>
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="ph ph-map-pin mr-2"></i>Địa chỉ <span class="text-red-500">*</span>
                </label>
                <textarea id="address" name="address" rows="3" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                    placeholder="Nhập địa chỉ đầy đủ" required>{{ old('address') }}</textarea>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="ph ph-phone mr-2"></i>Số điện thoại <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300"
                    placeholder="Nhập số điện thoại" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full h-12 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                <i class="ph ph-user-plus text-xl"></i>
                Đăng ký
            </button>
        </form>

        <!-- Login Link -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-4">Đã có tài khoản?</p>
            <a href="{{ route('patient.login') }}" 
                class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold transition-colors duration-300">
                <i class="ph ph-sign-in"></i>
                Đăng nhập ngay
            </a>
        </div>

        <!-- Back to Role Selection -->
        <div class="mt-6 text-center">
            <a href="{{ route('select.role') }}" 
                class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 transition-colors duration-300">
                <i class="ph ph-arrow-left"></i>
                Quay lại chọn quyền
            </a>
        </div>
    </div>

</body>
</html> 
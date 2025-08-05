<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Đăng nhập - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>   
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gradient-to-br from-blue-200 via-purple-100 to-pink-200 min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2 flex items-center justify-center gap-2">
                <i class="ph ph-user-circle text-blue-600 text-4xl"></i> 
                Đăng nhập Bệnh nhân
            </h1>
            <p class="text-gray-600">Vui lòng nhập thông tin đăng nhập của bạn</p>
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

        <!-- Login Form -->
        <form method="POST" action="{{ route('patient.login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="ph ph-envelope mr-2"></i>Gmail
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    placeholder="Nhập email của bạn" required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="ph ph-lock mr-2"></i>Mật khẩu
                </label>
                <input type="password" id="password" name="password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    placeholder="Nhập mật khẩu" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full h-12 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
                <i class="ph ph-sign-in text-xl"></i>
                Đăng nhập
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 mb-4">Chưa có tài khoản?</p>
            <a href="{{ route('patient.register') }}" 
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-300">
                <i class="ph ph-user-plus"></i>
                Đăng ký ngay
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
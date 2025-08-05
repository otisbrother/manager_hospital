<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔐 Chọn quyền đăng nhập</title>
  <script src="https://cdn.tailwindcss.com"></script>   
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gradient-to-br from-indigo-200 via-purple-100 to-pink-200 min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md text-center">
        <!-- Ẩn thông tin đăng nhập vì lý do bảo mật -->
        @if(session('patient_id') || session('patient_name'))
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-blue-800 text-sm">
                    <i class="ph ph-info text-blue-600"></i>
                    Bạn đã đăng nhập thành công
                </p>
                <form method="POST" action="{{ route('patient.logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm underline">
                        <i class="ph ph-sign-out"></i> Đăng xuất
                    </button>
                </form>
            </div>
        @endif

        <h1 class="text-3xl font-extrabold text-gray-800 mb-10 flex items-center justify-center gap-2">
            <i class="ph ph-lock-key text-indigo-600 text-4xl"></i> 
            Chọn quyền đăng nhập
        </h1>

        <div class="grid grid-cols-1 gap-6">
            <!-- Admin button -->
            <a href="{{ route('login.role', ['role' => 'admin']) }}"
                class="w-full h-16 flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold rounded-xl shadow-md transition-all duration-300 hover:scale-105">
                <i class="ph ph-shield-check text-2xl"></i> Admin
            </a>

            <!-- Doctor button -->
            <a href="{{ route('doctor.login') }}"
                class="w-full h-16 flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white text-lg font-semibold rounded-xl shadow-md transition-all duration-300 hover:scale-105">
                <i class="ph ph-stethoscope text-2xl"></i> Bác sĩ
            </a>

            <!-- Patient button -->
            <a href="{{ route('patient.login') }}"
                class="w-full h-16 flex items-center justify-center gap-3 bg-purple-600 hover:bg-purple-700 text-white text-lg font-semibold rounded-xl shadow-md transition-all duration-300 hover:scale-105">
                <i class="ph ph-user-circle text-2xl"></i> Bệnh nhân
            </a>
        </div>
    </div>

</body>
</html>

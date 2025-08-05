<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👨‍⚕️ Chi tiết nhập viện - Bác sĩ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen font-sans text-gray-800 bg-gradient-to-br from-purple-500 via-pink-200 to-white">
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
                        <h1 class="text-2xl font-bold text-gray-800">Chi tiết nhập viện</h1>
                        <p class="text-gray-600">Xem thông tin chi tiết nhập viện</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6">
            <div class="max-w-2xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Chi tiết nhập viện</h1>
                    <a href="{{ route('doctors.hospitalized.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                        <i class="ph ph-arrow-left mr-2"></i>Quay lại
                    </a>
                </div>

                <div class="bg-white shadow-md rounded-lg p-6">
                    <!-- Patient Information -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="ph ph-user-circle mr-2 text-blue-600"></i>
                            Thông tin bệnh nhân
                        </h2>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tên bệnh nhân</label>
                                    <p class="text-gray-900 font-medium">{{ $hospitalized->patient->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mã bệnh nhân</label>
                                    <p class="text-gray-900 font-medium">{{ $hospitalized->patient->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hospitalization Details -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="ph ph-bed mr-2 text-green-600"></i>
                            Thông tin nhập viện
                        </h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ngày nhập viện</label>
                                    <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($hospitalized->admission_date)->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phòng</label>
                                    <p class="text-gray-900 font-medium">{{ $hospitalized->room }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Giường</label>
                                <p class="text-gray-900 font-medium">{{ $hospitalized->bed }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="ph ph-stethoscope mr-2 text-red-600"></i>
                            Thông tin y tế
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Lý do nhập viện</label>
                                <div class="bg-gray-50 p-3 rounded-lg border">
                                    <p class="text-gray-900">{{ $hospitalized->reason ?? 'Chưa có thông tin' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Chẩn đoán</label>
                                <div class="bg-gray-50 p-3 rounded-lg border">
                                    <p class="text-gray-900">{{ $hospitalized->diagnosis ?? 'Chưa có thông tin' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="ph ph-clock mr-2 text-purple-600"></i>
                            Thông tin thời gian
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ngày tạo</label>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($hospitalized->created_at)->format('d/m/Y H:i:s') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cập nhật lần cuối</label>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($hospitalized->updated_at)->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('doctors.hospitalized.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                            <i class="ph ph-arrow-left mr-2"></i>Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        // Close sidebar when clicking overlay
        document.getElementById('overlay').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html> 
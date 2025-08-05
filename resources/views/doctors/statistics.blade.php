<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Thống kê khám bệnh - Bác sĩ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <h1 class="text-2xl font-bold text-gray-800">Thống kê khám bệnh</h1>
                        <p class="text-gray-600">Báo cáo chi tiết hoạt động khám chữa bệnh</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <select id="timeFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="month">Tháng này</option>
                        <option value="quarter">Quý này</option>
                        <option value="year">Năm này</option>
                    </select>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="p-6">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Patients Count -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Bệnh nhân đã khám</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $monthlyStats['patients_count'] }}</p>
                            <p class="text-sm text-gray-500 mt-1">Trong tháng {{ now()->format('m/Y') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-users text-2xl text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Prescriptions Count -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Đơn thuốc đã kê</p>
                            <p class="text-3xl font-bold text-green-600">{{ $monthlyStats['prescriptions_count'] }}</p>
                            <p class="text-sm text-gray-500 mt-1">Trong tháng {{ now()->format('m/Y') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-pill text-2xl text-green-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Medical Records Count -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Hồ sơ y tế</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $monthlyStats['medical_records_count'] }}</p>
                            <p class="text-sm text-gray-500 mt-1">Trong tháng {{ now()->format('m/Y') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="ph ph-folder-open text-2xl text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Daily Patients Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Số bệnh nhân theo ngày</h3>
                        <div class="text-sm text-gray-500">Tháng {{ now()->format('m/Y') }}</div>
                    </div>
                    <div class="h-80">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>

                <!-- Top Diseases Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Top 5 bệnh thường gặp</h3>
                        <div class="text-sm text-gray-500">Theo số lượng</div>
                    </div>
                    <div class="h-80">
                        <canvas id="diseasesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detailed Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Diseases Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Chi tiết bệnh thường gặp</h3>
                    
                    @if($topDiseases->count() > 0)
                        <div class="space-y-4">
                            @foreach($topDiseases as $disease)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                            <i class="ph ph-bug text-red-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-800">{{ $disease->disease_name }}</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $monthlyStats['medical_records_count'] > 0 ? round(($disease->count / $monthlyStats['medical_records_count']) * 100, 1) : 0 }}% tổng số ca
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-800">{{ $disease->count }}</p>
                                        <p class="text-sm text-gray-500">ca bệnh</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="ph ph-chart-bar text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">Chưa có dữ liệu thống kê</p>
                        </div>
                    @endif
                </div>

                <!-- Performance Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Tóm tắt hiệu suất</h3>
                    
                    <div class="space-y-6">
                        <!-- Average patients per day -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="ph ph-user text-blue-600"></i>
                                </div>
                                <span class="text-gray-700">Trung bình bệnh nhân/ngày</span>
                            </div>
                            <span class="font-semibold text-gray-800">
                                {{ $monthlyStats['patients_count'] > 0 ? round($monthlyStats['patients_count'] / now()->day, 1) : 0 }}
                            </span>
                        </div>

                        <!-- Average prescriptions per patient -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="ph ph-pill text-green-600"></i>
                                </div>
                                <span class="text-gray-700">Đơn thuốc/bệnh nhân</span>
                            </div>
                            <span class="font-semibold text-gray-800">
                                {{ $monthlyStats['patients_count'] > 0 ? round($monthlyStats['prescriptions_count'] / $monthlyStats['patients_count'], 1) : 0 }}
                            </span>
                        </div>

                        <!-- Working days this month -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="ph ph-calendar text-purple-600"></i>
                                </div>
                                <span class="text-gray-700">Ngày làm việc</span>
                            </div>
                            <span class="font-semibold text-gray-800">{{ now()->day }}/{{ now()->daysInMonth }}</span>
                        </div>

                        <!-- Productivity score -->
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-700">Điểm hiệu suất</span>
                                <span class="font-semibold text-green-600">
                                    {{ min(100, round(($monthlyStats['patients_count'] * 10 + $monthlyStats['prescriptions_count'] * 5) / 100, 0)) }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" 
                                     style="width: {{ min(100, round(($monthlyStats['patients_count'] * 10 + $monthlyStats['prescriptions_count'] * 5) / 100, 0)) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Options -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Xuất báo cáo</h3>
                <div class="flex flex-wrap gap-4">
                    <button onclick="exportReport('pdf')" 
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="ph ph-file-pdf"></i>
                        Xuất PDF
                    </button>
                    <button onclick="exportReport('excel')" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="ph ph-microsoft-excel-logo"></i>
                        Xuất Excel
                    </button>
                    <button onclick="printReport()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                        <i class="ph ph-printer"></i>
                        In báo cáo
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

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

        // Daily Chart
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');
        const dailyData = @json($dailyStats);
        
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyData.map(item => `Ngày ${item.day}`),
                datasets: [{
                    label: 'Số bệnh nhân',
                    data: dailyData.map(item => item.patients),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Diseases Chart
        const diseasesCtx = document.getElementById('diseasesChart').getContext('2d');
        const diseasesData = @json($topDiseases);
        
        new Chart(diseasesCtx, {
            type: 'doughnut',
            data: {
                labels: diseasesData.map(item => item.disease_name),
                datasets: [{
                    data: diseasesData.map(item => item.count),
                    backgroundColor: [
                        '#ef4444',
                        '#f97316',
                        '#eab308',
                        '#22c55e',
                        '#3b82f6'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Export functions
        function exportReport(type) {
            alert(`Tính năng xuất ${type.toUpperCase()} đang được phát triển!`);
        }

        function printReport() {
            window.print();
        }

        // Time filter handler
        document.getElementById('timeFilter').addEventListener('change', function() {
            // In real app, this would reload data with new time range
            console.log('Filtering by:', this.value);
        });
    </script>
</body>
</html> 
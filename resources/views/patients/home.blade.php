    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>🏥 Trang chủ - Bệnh nhân</title>
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
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Xin chào,</p>
                            <p class="font-semibold text-gray-800">{{ session('patient_name', 'Bệnh nhân') }}</p>
                            @php
                                $lastActivity = session('patient_last_activity');
                                $timeout = 10 * 60; // 10 phút
                                $remainingTime = $lastActivity ? max(0, $timeout - (time() - $lastActivity)) : 0;
                                $remainingMinutes = floor($remainingTime / 60);
                                $remainingSeconds = $remainingTime % 60;
                            @endphp
                            <p class="text-xs text-orange-600">
                                ⏰ Phiên còn: {{ $remainingMinutes }}:{{ str_pad($remainingSeconds, 2, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>
                        
                        <form method="POST" action="{{ route('patient.logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-300">
                                <i class="ph ph-sign-out"></i>
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                    <i class="ph ph-check-circle text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Patient Notifications -->
            @php
                $patientId = session('patient_id');
                $notification = session("patient_notification_{$patientId}");
            @endphp
            
            @if ($notification)
                <div class="notification-alert mb-6 p-6 rounded-2xl shadow-lg border-l-4 animate-pulse
                    {{ $notification['type'] === 'confirmed' ? 'bg-blue-50 border-blue-500' : 
                       ($notification['type'] === 'completed' ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500') }}">
                    
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            @if ($notification['type'] === 'confirmed')
                                <i class="ph ph-calendar-check text-blue-600 text-3xl"></i>
                            @elseif ($notification['type'] === 'completed')
                                <i class="ph ph-check-circle text-green-600 text-3xl"></i>
                            @else
                                <i class="ph ph-x-circle text-red-600 text-3xl"></i>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h4 class="text-lg font-bold mb-2
                                {{ $notification['type'] === 'confirmed' ? 'text-blue-800' : 
                                   ($notification['type'] === 'completed' ? 'text-green-800' : 'text-red-800') }}">
                                🔔 THÔNG BÁO QUAN TRỌNG
                            </h4>
                            
                            <div class="text-sm 
                                {{ $notification['type'] === 'confirmed' ? 'text-blue-700' : 
                                   ($notification['type'] === 'completed' ? 'text-green-700' : 'text-red-700') }}
                                whitespace-pre-line leading-relaxed">
                                {{ $notification['message'] }}
                            </div>
                            
                            <div class="mt-4 flex gap-3">
                                @if ($notification['type'] === 'confirmed' || $notification['type'] === 'completed')
                                    <button onclick="scrollToMedicalRecords()" 
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300 flex items-center gap-2">
                                        <i class="ph ph-file-text"></i>
                                        Xem hồ sơ y tế
                                    </button>
                                @endif
                                
                                <button onclick="dismissNotification()" 
                                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-300 flex items-center gap-2">
                                    <i class="ph ph-x"></i>
                                    Đã hiểu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                @php
                    // Xóa thông báo khỏi session sau khi hiển thị
                    session()->forget("patient_notification_{$patientId}");
                @endphp
            @endif
            
            <!-- Welcome Message -->
      
    <div id="welcome-message" class="bg-white rounded-2xl shadow-lg p-8 mb-8 transition-opacity duration-1000 opacity-100">

        <div class="text-center">
            <i class="ph ph-user-circle text-blue-600 text-6xl mb-4"></i>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Chào mừng bạn đến với trang chủ bệnh nhân!</h2>
            <p class="text-gray-600 text-lg">“Chỉ khi người giàu bị ốm họ mới thực sự hiểu được bất lực của giàu sang” (Benjamin Franklin).</p>
        </div>
    </div>




<div id="main-shortcuts" class="hidden">
    <div class="flex justify-center items-center gap-6 flex-wrap mb-8">
        <!-- Bác sĩ -->
        <a href="{{ route('patients.doctor') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold px-6 py-4 rounded-xl shadow-lg flex items-center gap-2 transition-transform transform hover:scale-105">
            <i class="ph ph-stethoscope text-2xl"></i> Bác sĩ
        </a>

        <!-- Khoa -->
        <a href="{{ route('patients.department') }}" class="bg-green-600 hover:bg-green-700 text-white text-lg font-semibold px-6 py-4 rounded-xl shadow-lg flex items-center gap-2 transition-transform transform hover:scale-105">
            <i class="ph ph-buildings text-2xl"></i> Khoa
        </a>

        <!-- Phòng viện -->
        <a href="{{ route('patients.room') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-semibold px-6 py-4 rounded-xl shadow-lg flex items-center gap-2 transition-transform transform hover:scale-105">
            <i class="ph ph-bed text-2xl"></i> Phòng viện
        </a>

   
     
    </div>
</div>



           <!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    <!-- Đặt lịch khám -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-calendar-check text-green-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Đặt lịch khám</h3>
            <p class="text-gray-600 mb-4">Đặt lịch hẹn với bác sĩ</p>
            <a href="{{ route('patient.appointment.create') }}" 
               class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Đặt lịch
            </a>
        </div>
    </div>

    <!-- Xem lịch hẹn -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-calendar-dots text-blue-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Lịch hẹn của tôi</h3>
            <p class="text-gray-600 mb-4">Xem tất cả lịch hẹn đã đặt</p>
            <a href="{{ route('patients.appointments') }}" 
               class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Xem lịch hẹn
            </a>
        </div>
    </div>

    <!-- Hồ sơ y tế -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-file-text text-blue-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Hồ sơ y tế</h3>
            <p class="text-gray-600 mb-4">Xem hồ sơ khám bệnh</p>
            <a href="{{ route('patients.medical-records') }}" 
               class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Xem hồ sơ
            </a>
        </div>
    </div>

    <!-- Đơn thuốc -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-pill text-purple-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Đơn thuốc</h3>
            <p class="text-gray-600 mb-4">Xem đơn thuốc đã kê</p>
            <a href="{{ route('patients.prescriptions') }}" 
               class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Xem đơn thuốc
            </a>
        </div>
    </div>

    <!-- Nhập/Xuất viện -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-bed text-red-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Nhập/Xuất viện</h3>
            <p class="text-gray-600 mb-4">Xem lịch sử điều trị nội trú</p>
            <a href="{{ route('patients.hospitalization') }}" 
               class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Xem chi tiết
            </a>
        </div>
    </div>

    <!-- Thông tin phòng -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-buildings text-indigo-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Thông tin phòng</h3>
            <p class="text-gray-600 mb-4">Xem thông tin phòng và giường hiện tại</p>
            <a href="{{ route('patients.room') }}" 
               class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Xem phòng
            </a>
        </div>
    </div>

    <!-- Thân nhân -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-users-three text-teal-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Thân nhân</h3>
            <p class="text-gray-600 mb-4">Thông tin người thân của bạn</p>
            <a href="{{ route('patients.relatives') }}" 
               class="w-full bg-teal-600 hover:bg-teal-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Xem thân nhân
            </a>
        </div>
    </div>

    <!-- Hóa đơn -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-receipt text-yellow-600 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tra cứu hóa đơn</h3>
            <p class="text-gray-600 mb-4">Xem chi tiết hóa đơn thanh toán</p>
            <a href="{{ route('patients.bills') }}" 
               class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Xem hóa đơn
            </a>
        </div>
    </div>

    <!-- Tài khoản -->
    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
        <div class="text-center">
            <i class="ph ph-lock-key text-gray-700 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tài khoản</h3>
            <p class="text-gray-600 mb-4">Đổi mật khẩu và thông tin</p>
            <a href="{{ route('patients.account') }}" 
               class="w-full bg-gray-700 hover:bg-gray-800 text-white py-2 px-4 rounded-lg transition-colors duration-300 inline-block text-center">
                Quản lý tài khoản
            </a>
        </div>
    </div>

</div>


            <!-- Information Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Patient Info -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="ph ph-info text-blue-600"></i>
                        Thông tin cá nhân
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mã bệnh nhân:</span>
                            <span class="font-semibold">{{ session('patient_id', 'N/A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Họ tên:</span>
                            <span class="font-semibold">{{ session('patient_name', 'N/A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Trạng thái:</span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Đang hoạt động</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="ph ph-clock text-orange-600"></i>
                        Hoạt động gần đây
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <i class="ph ph-sign-in text-green-600"></i>
                            <div>
                                <p class="font-semibold text-sm">Đăng nhập hệ thống</p>
                                <p class="text-xs text-gray-500">{{ now()->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p>&copy; 2025 Bệnh viện Heruko. Tất cả quyền được bảo lưu.</p>
            </div>
        </footer>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const msg = document.getElementById('welcome-message');
        const shortcuts = document.getElementById('main-shortcuts');

        if (msg && shortcuts) {
            // Ẩn phần chính
            shortcuts.classList.add('hidden');

            // Sau 2s, ẩn thông báo và hiện phần chính
            setTimeout(() => {
                msg.classList.add('opacity-0');
                setTimeout(() => {
                    msg.remove();
                    shortcuts.classList.remove('hidden');
                }, 1000);
            }, 2000);
        }
    });

    // Function to dismiss notification
    function dismissNotification() {
        const notification = document.querySelector('.notification-alert');
        if (notification) {
            notification.style.transition = 'opacity 0.5s, transform 0.5s';
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                notification.remove();
            }, 500);
        }
    }

    // Function to scroll to medical records section
    function scrollToMedicalRecords() {
        // Tìm thẻ hồ sơ y tế
        const medicalRecordsCard = Array.from(document.querySelectorAll('h3')).find(h3 => 
            h3.textContent.includes('Hồ sơ y tế')
        );
        
        if (medicalRecordsCard) {
            const card = medicalRecordsCard.closest('.bg-white');
            if (card) {
                // Smooth scroll to the card
                card.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                
                // Highlight effect
                card.style.transition = 'all 0.3s ease';
                card.style.transform = 'scale(1.05)';
                card.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
                card.style.borderColor = '#3B82F6';
                card.style.borderWidth = '2px';
                
                // Reset after 2 seconds
                setTimeout(() => {
                    card.style.transform = 'scale(1)';
                    card.style.boxShadow = '';
                    card.style.borderColor = '';
                    card.style.borderWidth = '';
                }, 2000);
            }
        }
        
        // Dismiss notification after scrolling
        setTimeout(() => {
            dismissNotification();
        }, 1000);
    }

    // Auto-dismiss notification after 30 seconds if user doesn't interact
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.querySelector('.notification-alert');
        if (notification) {
            setTimeout(() => {
                if (document.querySelector('.notification-alert')) {
                    dismissNotification();
                }
            }, 30000); // 30 seconds
        }
    });
</script>


    </body>
    

    <script>
        // Auto logout khi hết thời gian session
        @php
            $lastActivity = session('patient_last_activity');
            $timeout = 10 * 60; // 10 phút
            $remainingTime = $lastActivity ? max(0, $timeout - (time() - $lastActivity)) : 0;
        @endphp
        
        let remainingTime = {{ $remainingTime }};
        
        function updateTimer() {
            if (remainingTime <= 0) {
                // Tự động logout
                document.querySelector('form[action*="logout"]').submit();
                return;
            }
            
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            const timerElement = document.querySelector('.text-orange-600');
            if (timerElement) {
                timerElement.textContent = `⏰ Phiên còn: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            }
            
            remainingTime--;
        }
        
        // Cập nhật timer mỗi giây
        setInterval(updateTimer, 1000);
        
        // Cảnh báo khi còn 2 phút
        setTimeout(() => {
            if (remainingTime <= 120) { // 2 phút
                alert('⚠️ Phiên đăng nhập sẽ hết hạn trong 2 phút. Vui lòng lưu công việc của bạn.');
            }
        }, (remainingTime - 120) * 1000);
    </script>

    <script>
        // Debug: Kiểm tra khi click button
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('a[href*="patient"]');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    console.log('Clicking button:', this.href);
                    // Không ngăn chặn navigation
                });
            });
        });
    </script>
</html>

@php
use Phosphor\Icons\Phosphor;

$features = [
    ['label' => 'Lịch khám', 'url' => '/admin/appointments', 'icon' => 'ph-calendar-check'], 
    ['label' => 'Chi tiết bệnh nhân', 'url' => '/admin/patients', 'icon' => 'ph-user'],
    ['label' => 'Thẻ bảo hiểm', 'url' => '/admin/insurances', 'icon' => 'ph-identification-card'],
    ['label' => 'Thân nhân', 'url' => '/admin/relatives', 'icon' => 'ph-users'],
    ['label' => 'Khoa', 'url' => '/admin/departments', 'icon' => 'ph-buildings'],
    ['label' => 'Loại bệnh nhân', 'url' => '/admin/type_patients', 'icon' => 'ph-user-list'],
    ['label' => 'Bác sĩ', 'url' => '/admin/doctors', 'icon' => 'ph-stethoscope'],
    ['label' => 'Thuốc', 'url' => '/admin/medicines', 'icon' => 'ph-pill'],
    ['label' => 'Đơn thuốc', 'url' => '/admin/prescriptions', 'icon' => 'ph-clipboard-text'],
    ['label' => 'Chi tiết đơn thuốc', 'url' => '/admin/detail-prescriptions', 'icon' => 'ph-list'],
    ['label' => 'Sổ khám bệnh', 'url' => '/admin/medical-records', 'icon' => 'ph-book'],
    ['label' => 'Chi tiết sổ khám', 'url' => '/admin/detail-medicalrecords', 'icon' => 'ph-note-pencil'],
    ['label' => 'Hóa đơn viện phí', 'url' => '/admin/bills', 'icon' => 'ph-receipt'],
    ['label' => 'Nhập viện', 'url' => '/admin/hospitalized', 'icon' => 'ph-door'],
    ['label' => 'Xuất viện', 'url' => '/admin/discharges', 'icon' => 'ph-door'],
];
@endphp

<x-app-layout>
    <x-slot name="header">
<h2 class="text-[12px] font-extrabold italic text-indigo-700 text-center mt-4 mb-8 tracking-widest drop-shadow-lg">
    {{ __('Chào mừng bạn đến với trang admin') }}
</h2>

        {{-- 🔔 Khung thông báo lịch hẹn mới --}}
        <div id="notification-container" class="fixed top-4 right-4 z-50 w-[480px] max-h-[75vh] overflow-hidden" style="display: none;">
            <div class="bg-white rounded-xl shadow-2xl border border-gray-200 p-5 relative">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-blue-800 flex items-center gap-2">
                         <span>Thông báo lịch hẹn mới</span>
                        <span id="notification-count" class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">0</span>
                    </h3>
                    <button id="close-notifications" class="text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="ph-x text-xl"></i>
                    </button>
                </div>
                <div id="notifications-list" class="space-y-3 max-h-96 overflow-y-auto pr-1 custom-scrollbar scroll-shadow relative">
                    <!-- Thông báo sẽ được load bằng JavaScript -->
                </div>
                <div id="scroll-indicator" class="scroll-indicator">
                    <i class="ph-caret-down text-xs"></i>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <button id="mark-all-read" class="w-full bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                        <i class="ph-check-circle text-base"></i>
                        Đánh dấu tất cả đã đọc
                    </button>
                </div>
            </div>
        </div>

        {{-- 🔔 Nút thông báo floating - Di chuyển xuống và làm nổi bật hơn --}}
        <div id="notification-bell" class="fixed top-20 right-6 z-50" style="background: rgba(59, 130, 246, 0.1); padding: 10px; border-radius: 50%; ">
           <button>
               🔔
           </button>
        </div>

    </x-slot>
    @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
 <div class="py-4 px-6 bg-gradient-to-br from-purple-50 via-white to-pink-50 min-h-screen">

        <div class="max-w-full mx-auto">
            <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                
                {{-- Chức năng (trái) - Fixed width --}}
                <div class="w-80 bg-white rounded-2xl shadow-xl p-6 border overflow-y-auto">
                    <h3 class="text-xl font-bold text-blue-800 mb-4 sticky top-0 bg-white pb-2">📋 Chức năng quản lý</h3>
                    <div class="space-y-3">
                        @foreach ($features as $feature)
                            <form action="{{ url($feature['url']) }}" method="GET">
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 bg-blue-100 hover:bg-blue-200 rounded-xl text-left text-blue-900 font-medium shadow-sm transition-all duration-200 hover:scale-[1.02] text-sm">
                                    <i class="{{ $feature['icon'] }} text-lg"></i>
                                    {{ $feature['label'] }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>

                {{-- Biểu đồ (phải) - Flexible width --}}
                <div class="flex-1 bg-white rounded-2xl shadow-xl p-6 border flex flex-col">
                    <h3 class="text-2xl font-bold text-purple-800 mb-6 text-center">📊 Thống kê số lượng theo chức năng quản lý bệnh viện</h3>
                    <div class="flex-1 relative min-h-[500px]">
                        <canvas id="functionChart" class="w-full h-full"></canvas>
                    </div>
                </div>

            </div>              
        </div>
    </div>

    {{-- Load Phosphor Icons và Chart.js --}}
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Custom CSS cho thanh trượt --}}
    <style>
        /* Custom Scrollbar cho notifications */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f8fafc;
        }

        /* Webkit browsers (Chrome, Safari, Edge) */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
            margin: 5px 0;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #60a5fa, #3b82f6);
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #3b82f6, #1d4ed8);
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:active {
            background: linear-gradient(180deg, #1d4ed8, #1e40af);
        }

        /* Animations cho smooth scrolling */
        .custom-scrollbar {
            scroll-behavior: smooth;
        }

        /* Hover effect cho container */
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #3b82f6, #2563eb);
        }

        /* Custom shadow cho scrollable area */
        .scroll-shadow {
            background: 
                linear-gradient(white 30%, rgba(255,255,255,0)),
                linear-gradient(rgba(255,255,255,0), white 70%) 0 100%,
                radial-gradient(farthest-side at 50% 0, rgba(0,0,0,.08), rgba(0,0,0,0)),
                radial-gradient(farthest-side at 50% 100%, rgba(0,0,0,.08), rgba(0,0,0,0)) 0 100%;
            background-repeat: no-repeat;
            background-color: white;
            background-size: 100% 30px, 100% 30px, 100% 10px, 100% 10px;
            background-attachment: local, local, scroll, scroll;
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: absolute;
            right: 12px;
            bottom: 50px;
            width: 20px;
            height: 20px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.2);
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .scroll-indicator.visible {
            opacity: 1;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Scrollbar enhanced cho mobile */
        @media (max-width: 768px) {
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
        }
    </style>
    <script>
        // Đảm bảo DOM và Chart.js đã load xong
        document.addEventListener('DOMContentLoaded', function() {
            // Dữ liệu biểu đồ
            const functionStats = {!! json_encode($functionStats ?? []) !!};
            
            // Kiểm tra xem có dữ liệu không
            if (!functionStats || Object.keys(functionStats).length === 0) {
                document.getElementById('functionChart').innerHTML = '<p class="text-center text-red-500">Không có dữ liệu để hiển thị</p>';
                return;
            }

            // Lấy canvas element
            const canvas = document.getElementById('functionChart');
            if (!canvas) {
                return;
            }

            const ctx = canvas.getContext('2d');
            
            try {
                // Tạo biểu đồ
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(functionStats),
                        datasets: [{
                            label: 'Số lượng',
                            data: Object.values(functionStats),
                            backgroundColor: [
                                '#3b82f6', // Bệnh nhân - xanh dương
                                '#10b981', // Bác sĩ - xanh lá
                                '#8b5cf6', // Đơn thuốc - tím
                                '#f59e0b', // Nhập viện - vàng
                                '#ef4444', // Xuất viện - đỏ
                                '#6366f1'  // Sổ khám bệnh - tím đậm
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                                         options: {
                         responsive: true,
                         maintainAspectRatio: false,
                         layout: {
                             padding: {
                                 top: 10,
                                 right: 30,
                                 bottom: 30,
                                 left: 30
                             }
                         },
                        plugins: {
                            legend: { 
                                display: false 
                            },
                            tooltip: {
                                backgroundColor: '#1f2937',
                                titleColor: '#f9fafb',
                                bodyColor: '#f9fafb',
                                borderColor: '#374151',
                                borderWidth: 1,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                                                 scales: {
                             y: {
                                 beginAtZero: true,
                                 ticks: { 
                                     stepSize: 50,
                                     color: '#374151',
                                     font: {
                                         size: 14,
                                         weight: '500'
                                     },
                                     padding: 10
                                 },
                                 grid: {
                                     color: '#e5e7eb',
                                     drawBorder: false
                                 },
                                 title: {
                                     display: true,
                                     text: 'Số lượng',
                                     color: '#374151',
                                     font: {
                                         size: 16,
                                         weight: 'bold'
                                     }
                                 }
                             },
                             x: {
                                 ticks: {
                                     color: '#374151',
                                     font: {
                                         size: 14,
                                         weight: 'bold'
                                     },
                                     maxRotation: 0,
                                     minRotation: 0,
                                     padding: 15
                                 },
                                 grid: {
                                     display: false
                                 }
                             }
                         },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        }
                    }
                });

                // Biểu đồ tạo thành công
                
            } catch (error) {
                canvas.innerHTML = '<p class="text-center text-red-500">Có lỗi khi tạo biểu đồ</p>';
            }
        });

        // === 🔔 NOTIFICATION SYSTEM ===
        let currentNotifications = [];
        let currentInsuranceNotifications = [];
        let isNotificationOpen = false;
        let notificationSound = null;

        // Tạo âm thanh thông báo
        function createNotificationSound() {
            // Tạo âm thanh đơn giản bằng Web Audio API
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            return function() {
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.1);
                
                gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.3);
            };
        }

        // Khởi tạo âm thanh
        try {
            notificationSound = createNotificationSound();
        } catch (error) {
            // Âm thanh không khả dụng
        }

        // Lấy thông báo từ server
        async function fetchNotifications() {
            try {
                const response = await fetch('/admin/notifications');
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Lỗi khi lấy thông báo:', error);
                return { notifications: [], count: 0 };
            }
        }

        // Lấy thông báo đăng ký mức hỗ trợ viện phí
        async function fetchInsuranceNotifications() {
            try {
                const response = await fetch('/admin/notifications/insurance');
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Lỗi khi lấy thông báo đăng ký mức hỗ trợ:', error);
                return { notifications: [], count: 0 };
            }
        }

        // Biến global để tracking trạng thái hiển thị
        let showAllNotifications = false;
        const MAX_INITIAL_NOTIFICATIONS = 3;

        // Hiển thị thông báo
        function displayNotifications(notifications, insuranceNotifications = []) {
            const notificationsList = document.getElementById('notifications-list');
            const notificationCount = document.getElementById('notification-count');
            const notificationBadge = document.getElementById('notification-badge');
            
            // Cập nhật số lượng tổng
            const totalCount = notifications.length + insuranceNotifications.length;
            
            // Cập nhật floating bell
            if (notificationCount) notificationCount.textContent = totalCount;
            if (notificationBadge) notificationBadge.textContent = totalCount;
            
            if (totalCount > 0) {
                if (notificationBadge) notificationBadge.style.display = 'flex';
            } else {
                if (notificationBadge) notificationBadge.style.display = 'none';
            }

            // Tạo HTML cho từng thông báo
            if (totalCount === 0) {
                notificationsList.innerHTML = `
                    <div class="text-center text-gray-500 py-4">
                        <i class="ph-bell-slash text-3xl mb-2"></i>
                        <p>Không có thông báo mới</p>
                    </div>
                `;
                return;
            }

            // Tạo HTML cho thông báo lịch hẹn
            const appointmentNotificationsHTML = notifications.map((notification, index) => {
                const isNewNotification = index < MAX_INITIAL_NOTIFICATIONS;
                const bgClass = isNewNotification ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200';
                const hoverClass = isNewNotification ? 'hover:bg-blue-100' : 'hover:bg-gray-100';
                
                return `
                <div class="notification-item ${bgClass} border rounded-lg p-3 ${hoverClass} transition-all duration-200 ${!isNewNotification ? 'opacity-90' : ''}" data-id="${notification.id}" data-type="appointment">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-blue-900 mb-1">
                                        📅 Lịch hẹn mới từ <strong>${notification.patient_name}</strong>
                                    </p>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-md text-xs font-mono font-medium">
                                            BN: ${notification.patient_id}
                                        </span>
                                        <span class="inline-block w-1 h-1 bg-red-500 rounded-full animate-pulse"></span>
                                    </div>
                                </div>
                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full animate-pulse ml-2 mt-1"></span>
                            </div>
                            <div class="text-xs text-gray-600 space-y-2 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium min-w-[50px]">Bác sĩ:</span> 
                                    <span>${notification.doctor_name}</span>
                                    ${notification.doctor_id ? `<span class="bg-green-100 text-green-800 px-2 py-1 rounded-md font-mono font-medium">BS: ${notification.doctor_id}</span>` : '<span class="text-gray-400 italic">Chưa phân công</span>'}
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium min-w-[50px]">Khoa:</span>
                                    <span>${notification.department_name}</span>
                                    ${notification.department_id ? `<span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-md font-mono font-medium">KH: ${notification.department_id}</span>` : '<span class="text-gray-400 italic">N/A</span>'}
                                </div>
                                <p><span class="font-medium">Ngày hẹn:</span> <span class="font-medium text-gray-800">${new Date(notification.appointment_date).toLocaleDateString('vi-VN')}</span></p>
                                <p><span class="font-medium">Triệu chứng:</span> <span class="text-gray-700">${notification.symptoms || 'Không có'}</span></p>
                                <p><span class="font-medium">Thời gian:</span> <span class="text-orange-600">${notification.time_ago}</span></p>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button class="mark-single-read-btn bg-green-500 hover:bg-green-600 text-black px-3 py-1 rounded text-xs font-medium transition-colors flex items-center gap-1" data-id="${notification.id}" data-type="appointment">
                                    <i class="ph-check text-sm"></i>
                                    Đánh dấu đã đọc
                                </button>
                                <button class="view-appointment-btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors flex items-center gap-1" data-id="${notification.id}">
                                    <i class="ph-eye text-sm"></i>
                                    Xem chi tiết
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            }).join('');

            // Tạo HTML cho thông báo đăng ký mức hỗ trợ
            const insuranceNotificationsHTML = insuranceNotifications.map((notification, index) => {
                const isNewNotification = index < MAX_INITIAL_NOTIFICATIONS;
                const bgClass = isNewNotification ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200';
                const hoverClass = isNewNotification ? 'hover:bg-green-100' : 'hover:bg-gray-100';
                
                return `
                <div class="notification-item ${bgClass} border rounded-lg p-3 ${hoverClass} transition-all duration-200 ${!isNewNotification ? 'opacity-90' : ''}" data-id="${notification.id}" data-type="insurance">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-green-900 mb-1">
                                        💳 Đăng ký mức hỗ trợ từ <strong>${notification.patient_name}</strong>
                                    </p>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md text-xs font-mono font-medium">
                                            BN: ${notification.patient_id}
                                        </span>
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-md text-xs font-mono font-medium">
                                            ${notification.support_level_text}
                                        </span>
                                        <span class="inline-block w-1 h-1 bg-red-500 rounded-full animate-pulse"></span>
                                    </div>
                                </div>
                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full animate-pulse ml-2 mt-1"></span>
                            </div>
                            <div class="text-xs text-gray-600 space-y-2 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium min-w-[50px]">Mã BHYT:</span>
                                    <span>${notification.insurance_id || 'Chưa có'}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium min-w-[50px]">Mức hỗ trợ:</span>
                                    <span class="font-medium text-green-700">${notification.support_level}%</span>
                                    <span class="text-gray-500">(${notification.support_level_text.split('(')[1]?.replace(')', '') || ''})</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium min-w-[50px]">Trạng thái:</span>
                                    <span class="font-medium text-orange-600">${notification.status_text}</span>
                                </div>
                                <p><span class="font-medium">Thời gian:</span> <span class="text-orange-600">${notification.time_ago}</span></p>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button class="mark-single-read-btn bg-green-500 hover:bg-green-600 text-black px-3 py-1 rounded text-xs font-medium transition-colors flex items-center gap-1" data-id="${notification.id}" data-type="insurance">
                                    <i class="ph-check text-sm"></i>
                                    Đánh dấu đã đọc
                                </button>
                                <button class="view-insurance-btn bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors flex items-center gap-1" data-id="${notification.id}">
                                    <i class="ph-eye text-sm"></i>
                                    Xem chi tiết
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            }).join('');

            // Kết hợp cả hai loại thông báo
            const allNotifications = [...notifications, ...insuranceNotifications];
            const notificationsToShow = showAllNotifications ? allNotifications : allNotifications.slice(0, MAX_INITIAL_NOTIFICATIONS);
            const hasMore = allNotifications.length > MAX_INITIAL_NOTIFICATIONS;

            // Tạo HTML tổng hợp
            const notificationsHTML = notificationsToShow.map((notification, index) => {
                if (notification.type === 'insurance') {
                    // Đây là thông báo đăng ký mức hỗ trợ
                    const isNewNotification = index < MAX_INITIAL_NOTIFICATIONS;
                    const bgClass = isNewNotification ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200';
                    const hoverClass = isNewNotification ? 'hover:bg-green-100' : 'hover:bg-gray-100';
                    
                    return `
                    <div class="notification-item ${bgClass} border rounded-lg p-3 ${hoverClass} transition-all duration-200 ${!isNewNotification ? 'opacity-90' : ''}" data-id="${notification.id}" data-type="insurance">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-green-900 mb-1">
                                            💳 Đăng ký mức hỗ trợ từ <strong>${notification.patient_name}</strong>
                                        </p>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md text-xs font-mono font-medium">
                                                BN: ${notification.patient_id}
                                            </span>
                                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-md text-xs font-mono font-medium">
                                                ${notification.support_level_text}
                                            </span>
                                            <span class="inline-block w-1 h-1 bg-red-500 rounded-full animate-pulse"></span>
                                        </div>
                                    </div>
                                    <span class="inline-block w-2 h-2 bg-red-500 rounded-full animate-pulse ml-2 mt-1"></span>
                                </div>
                                <div class="text-xs text-gray-600 space-y-2 mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium min-w-[50px]">Mã BHYT:</span>
                                        <span>${notification.insurance_id || 'Chưa có'}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium min-w-[50px]">Mức hỗ trợ:</span>
                                        <span class="font-medium text-green-700">${notification.support_level}%</span>
                                        <span class="text-gray-500">(${notification.support_level_text.split('(')[1]?.replace(')', '') || ''})</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium min-w-[50px]">Trạng thái:</span>
                                        <span class="font-medium text-orange-600">${notification.status_text}</span>
                                    </div>
                                    <p><span class="font-medium">Thời gian:</span> <span class="text-orange-600">${notification.time_ago}</span></p>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button class="mark-single-read-btn bg-green-500 hover:bg-green-600 text-black px-3 py-1 rounded text-xs font-medium transition-colors flex items-center gap-1" data-id="${notification.id}" data-type="insurance">
                                        <i class="ph-check text-sm"></i>
                                        Đánh dấu đã đọc
                                    </button>
                                    <button class="view-insurance-btn bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors flex items-center gap-1" data-id="${notification.id}">
                                        <i class="ph-eye text-sm"></i>
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                } else {
                    // Đây là thông báo lịch hẹn
                    const isNewNotification = index < MAX_INITIAL_NOTIFICATIONS;
                    const bgClass = isNewNotification ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200';
                    const hoverClass = isNewNotification ? 'hover:bg-blue-100' : 'hover:bg-gray-100';
                    
                    return `
                    <div class="notification-item ${bgClass} border rounded-lg p-3 ${hoverClass} transition-all duration-200 ${!isNewNotification ? 'opacity-90' : ''}" data-id="${notification.id}" data-type="appointment">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-blue-900 mb-1">
                                            📅 Lịch hẹn mới từ <strong>${notification.patient_name}</strong>
                                        </p>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-md text-xs font-mono font-medium">
                                                BN: ${notification.patient_id}
                                            </span>
                                            <span class="inline-block w-1 h-1 bg-red-500 rounded-full animate-pulse"></span>
                                        </div>
                                    </div>
                                    <span class="inline-block w-2 h-2 bg-red-500 rounded-full animate-pulse ml-2 mt-1"></span>
                                </div>
                                <div class="text-xs text-gray-600 space-y-2 mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium min-w-[50px]">Bác sĩ:</span> 
                                        <span>${notification.doctor_name}</span>
                                        ${notification.doctor_id ? `<span class="bg-green-100 text-green-800 px-2 py-1 rounded-md font-mono font-medium">BS: ${notification.doctor_id}</span>` : '<span class="text-gray-400 italic">Chưa phân công</span>'}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium min-w-[50px]">Khoa:</span>
                                        <span>${notification.department_name}</span>
                                        ${notification.department_id ? `<span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-md font-mono font-medium">KH: ${notification.department_id}</span>` : '<span class="text-gray-400 italic">N/A</span>'}
                                    </div>
                                    <p><span class="font-medium">Ngày hẹn:</span> <span class="font-medium text-gray-800">${new Date(notification.appointment_date).toLocaleDateString('vi-VN')}</span></p>
                                    <p><span class="font-medium">Triệu chứng:</span> <span class="text-gray-700">${notification.symptoms || 'Không có'}</span></p>
                                    <p><span class="font-medium">Thời gian:</span> <span class="text-orange-600">${notification.time_ago}</span></p>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <button class="mark-single-read-btn bg-green-500 hover:bg-green-600 text-black px-3 py-1 rounded text-xs font-medium transition-colors flex items-center gap-1" data-id="${notification.id}" data-type="appointment">
                                        <i class="ph-check text-sm"></i>
                                        Đánh dấu đã đọc
                                    </button>
                                    <button class="view-appointment-btn bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-medium transition-colors flex items-center gap-1" data-id="${notification.id}">
                                        <i class="ph-eye text-sm"></i>
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                }
            }).join('');

            // Tạo nút "Xem thêm" / "Thu gọn" nếu cần
            let expandButton = '';
            if (hasMore) {
                const hiddenCount = notifications.length - MAX_INITIAL_NOTIFICATIONS;
                expandButton = `
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <button id="toggle-notifications" class="w-full text-blue-600 hover:text-blue-700 hover:bg-blue-50 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-center gap-2 group">
                            ${showAllNotifications ? 
                                '<i class="ph-caret-up text-base group-hover:translate-y-[-2px] transition-transform"></i>Thu gọn' : 
                                `<i class="ph-caret-down text-base group-hover:translate-y-[2px] transition-transform"></i>Xem thêm <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs font-bold ml-1">${hiddenCount}</span> thông báo`
                            }
                        </button>
                    </div>
                `;
            }

            // Cập nhật nội dung
            notificationsList.innerHTML = notificationsHTML + expandButton;

            // Smooth scroll to top khi có thông báo mới hoặc toggle
            setTimeout(() => {
                notificationsList.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                updateScrollIndicator();
            }, 100);

            // Setup scroll listener nếu chưa có
            setupScrollListener();
        }

        // Đánh dấu tất cả đã đọc
        async function markAllAsRead() {
            if (currentNotifications.length === 0 && currentInsuranceNotifications.length === 0) return;

            try {
                // Đánh dấu thông báo lịch hẹn
                if (currentNotifications.length > 0) {
                    const appointmentIds = currentNotifications.map(n => n.id);
                    await fetch('/admin/notifications/mark-read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ appointment_ids: appointmentIds })
                    });
                }

                // Đánh dấu thông báo đăng ký mức hỗ trợ
                if (currentInsuranceNotifications.length > 0) {
                    const applicationIds = currentInsuranceNotifications.map(n => n.id);
                    await fetch('/admin/notifications/insurance/mark-read', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ application_ids: applicationIds })
                    });
                }

                // Reset tất cả thông báo
                currentNotifications = [];
                currentInsuranceNotifications = [];
                displayNotifications([], []);
                
                showToast('Đã đánh dấu tất cả thông báo đã đọc', 'success');
            } catch (error) {
                console.error('Lỗi khi đánh dấu đã đọc:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại', 'error');
            }
        }

        // Đánh dấu một thông báo đã đọc
        async function markSingleAsRead(appointmentId) {
            try {
                const response = await fetch('/admin/notifications/mark-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ appointment_ids: [appointmentId] })
                });

                if (response.ok) {
                    
                    // Thêm animation fade out cho item được đánh dấu
                    const notificationItem = document.querySelector(`[data-id="${appointmentId}"]`);
                    if (notificationItem) {
                        notificationItem.style.transition = 'all 0.5s ease-out';
                        notificationItem.style.opacity = '0.5';
                        notificationItem.style.transform = 'translateX(20px)';
                        notificationItem.style.backgroundColor = '#f0f9ff';
                        
                        // Sau 500ms thì remove khỏi list
                        setTimeout(() => {
                            // Tìm và xóa notification khỏi currentNotifications
                            currentNotifications = currentNotifications.filter(n => n.id != appointmentId);
                            
                            // Cập nhật UI
                            displayNotifications(currentNotifications, currentInsuranceNotifications);
                        }, 500);
                    } else {
                        // Fallback nếu không tìm thấy element
                        currentNotifications = currentNotifications.filter(n => n.id != appointmentId);
                        displayNotifications(currentNotifications, currentInsuranceNotifications);
                    }
                    
                    // Hiển thị toast notification
                    showToast('Đã đánh dấu thông báo đã đọc', 'success');
                } else {
                    throw new Error('Server error');
                }
            } catch (error) {
                console.error('Lỗi khi đánh dấu đã đọc:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại', 'error');
            }
        }

        // Đánh dấu một thông báo đăng ký mức hỗ trợ đã đọc
        async function markInsuranceSingleAsRead(applicationId) {
            try {
                const response = await fetch('/admin/notifications/insurance/mark-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ application_ids: [applicationId] })
                });

                if (response.ok) {
                    
                    // Thêm animation fade out cho item được đánh dấu
                    const notificationItem = document.querySelector(`[data-id="${applicationId}"]`);
                    if (notificationItem) {
                        notificationItem.style.transition = 'all 0.5s ease-out';
                        notificationItem.style.opacity = '0.5';
                        notificationItem.style.transform = 'translateX(20px)';
                        notificationItem.style.backgroundColor = '#f0fdf4';
                        
                        // Sau 500ms thì remove khỏi list
                        setTimeout(() => {
                            // Tìm và xóa notification khỏi currentInsuranceNotifications
                            currentInsuranceNotifications = currentInsuranceNotifications.filter(n => n.id != applicationId);
                            
                            // Cập nhật UI
                            displayNotifications(currentNotifications, currentInsuranceNotifications);
                        }, 500);
                    } else {
                        // Fallback nếu không tìm thấy element
                        currentInsuranceNotifications = currentInsuranceNotifications.filter(n => n.id != applicationId);
                        displayNotifications(currentNotifications, currentInsuranceNotifications);
                    }
                    
                    // Hiển thị toast notification
                    showToast('Đã đánh dấu thông báo đăng ký mức hỗ trợ đã đọc', 'success');
                } else {
                    throw new Error('Server error');
                }
            } catch (error) {
                console.error('Lỗi khi đánh dấu đã đọc:', error);
                showToast('Có lỗi xảy ra, vui lòng thử lại', 'error');
            }
        }

        // Hiển thị toast notification
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 left-1/2 transform -translate-x-1/2 z-[9999] px-4 py-2 rounded-lg text-white text-sm font-medium transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, -20px)';
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3000);
        }

        // Polling thông báo
        let previousCount = 0;
        async function pollNotifications() {
            const appointmentData = await fetchNotifications();
            const insuranceData = await fetchInsuranceNotifications();
            
            const newCount = appointmentData.count + insuranceData.count;
            
            // Reset trạng thái hiển thị nếu có thông báo mới
            if (newCount > previousCount && previousCount > 0) {
                showAllNotifications = false; // Thu gọn lại khi có thông báo mới
                
                // Phát âm thanh nếu có thông báo mới
                if (notificationSound) {
                    try {
                        notificationSound();
                    } catch (error) {
                        // Không thể phát âm thanh
                    }
                }
            }
            
            previousCount = newCount;
            currentNotifications = appointmentData.notifications;
            currentInsuranceNotifications = insuranceData.notifications;
            displayNotifications(appointmentData.notifications, insuranceData.notifications);
        }

        // Event listeners
        document.getElementById('notification-bell').addEventListener('click', function() {
            const container = document.getElementById('notification-container');
            isNotificationOpen = !isNotificationOpen;
            container.style.display = isNotificationOpen ? 'block' : 'none';
        });

        document.getElementById('close-notifications').addEventListener('click', function() {
            document.getElementById('notification-container').style.display = 'none';
            isNotificationOpen = false;
        });

        document.getElementById('mark-all-read').addEventListener('click', markAllAsRead);

        // Cập nhật scroll indicator
        function updateScrollIndicator() {
            const notificationsList = document.getElementById('notifications-list');
            const scrollIndicator = document.getElementById('scroll-indicator');
            
            if (!notificationsList || !scrollIndicator) return;
            
            const { scrollTop, scrollHeight, clientHeight } = notificationsList;
            const hasMoreContent = scrollHeight > clientHeight;
            const isScrolledToBottom = scrollTop + clientHeight >= scrollHeight - 5;
            
            // Hiển thị indicator nếu có nội dung để scroll và chưa scroll hết
            if (hasMoreContent && !isScrolledToBottom) {
                scrollIndicator.classList.add('visible');
            } else {
                scrollIndicator.classList.remove('visible');
            }
        }

        // Setup scroll listener
        let scrollListenerSetup = false;
        function setupScrollListener() {
            if (scrollListenerSetup) return;
            
            const notificationsList = document.getElementById('notifications-list');
            if (!notificationsList) return;
            
            notificationsList.addEventListener('scroll', updateScrollIndicator);
            scrollListenerSetup = true;
        }

        // Toggle hiển thị tất cả thông báo với animation
        function toggleNotificationDisplay() {
            const notificationsList = document.getElementById('notifications-list');
            
            // Thêm loading effect
            notificationsList.style.opacity = '0.7';
            notificationsList.style.transition = 'opacity 0.2s ease';
            
            setTimeout(() => {
                showAllNotifications = !showAllNotifications;
                displayNotifications(currentNotifications);
                
                // Khôi phục opacity
                notificationsList.style.opacity = '1';
            }, 150);
        }

        // Event delegation cho các nút trong notifications list
        document.getElementById('notifications-list').addEventListener('click', function(event) {
            const target = event.target.closest('button');
            if (!target) return;

            // Xử lý nút toggle "Xem thêm" / "Thu gọn"
            if (target.id === 'toggle-notifications') {
                toggleNotificationDisplay();
                return;
            }

            const notificationId = target.getAttribute('data-id');
            const notificationType = target.getAttribute('data-type');
            
            if (target.classList.contains('mark-single-read-btn')) {
                // Xử lý nút "Đánh dấu đã đọc" đơn lẻ
                if (notificationType === 'insurance') {
                    markInsuranceSingleAsRead(notificationId);
                } else {
                    markSingleAsRead(notificationId);
                }
            } else if (target.classList.contains('view-appointment-btn')) {
                // Xử lý nút "Xem chi tiết" lịch hẹn
                const url = `/admin/appointments/${notificationId}`;
                window.open(url, '_blank'); // Mở tab mới
            } else if (target.classList.contains('view-insurance-btn')) {
                // Xử lý nút "Xem chi tiết" đăng ký mức hỗ trợ
                const url = `/admin/insurances/application/${notificationId}`;
                window.open(url, '_blank'); // Mở tab mới
            }
        });

        // Đóng thông báo khi click bên ngoài
        document.addEventListener('click', function(event) {
            const container = document.getElementById('notification-container');
            const bell = document.getElementById('notification-bell');
            
            if (isNotificationOpen && !container.contains(event.target) && !bell.contains(event.target)) {
                container.style.display = 'none';
                isNotificationOpen = false;
            }
        });

        // Khởi tạo notification elements
        const bellElement = document.getElementById('notification-bell');
        if (bellElement) {
            bellElement.style.display = 'block';
            bellElement.style.visibility = 'visible';
        }

        // Bắt đầu polling mỗi 10 giây
        pollNotifications(); // Load lần đầu
        setInterval(pollNotifications, 10000); // Mỗi 10 giây
        
    </script>
    </div>
   
    @endsection
</x-app-layout>

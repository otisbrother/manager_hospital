<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Chọn phòng - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>   
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-blue-500 via-purple-200 to-white">

    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <i class="ph ph-hospital text-blue-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Bệnh viện Heruko</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('patients.home') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-300">
                <i class="ph ph-house"></i>
                Về trang chủ
            </a>
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

        <!-- Error Message -->
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="ph ph-warning text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Page Title -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4 flex items-center justify-center gap-3">
                <i class="ph ph-bed text-blue-600"></i>
                 Phòng bệnh
            </h1>
            <p class="text-gray-600 text-lg">Xem phòng (kèm mã phòng + số giường) phù hợp với nhu cầu của bạn sau đó thông báo với admin để làm thủ tục nhập viện</p>
        </div>

        <!-- Room Selection Section -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="ph ph-buildings text-blue-600"></i>
                    Danh sách phòng bệnh
                </h2>
                <!-- Nút thêm nhập viện chỉ dành cho admin -->
                @if(session('admin_id'))
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-300 flex items-center gap-2">
                        <i class="ph ph-plus"></i>
                        + Thêm nhập viện
                    </button>
                @endif
            </div>

            <!-- Room Table -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b-2 border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                PHÒNG
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                GIƯỜNG
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                TRẠNG THÁI
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                THAO TÁC
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            // Dữ liệu phòng mẫu
                            $rooms = [
                                ['code' => 'MA759', 'beds' => 6, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop'],
                                ['code' => 'BA123', 'beds' => 7, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=400&h=300&fit=crop'],
                                ['code' => 'TA708', 'beds' => 5, 'status' => 'occupied', 'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=400&h=300&fit=crop'],
                                ['code' => 'LA902', 'beds' => 4, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop'],
                                ['code' => 'CA476', 'beds' => 11, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=400&h=300&fit=crop'],
                                ['code' => 'RA582', 'beds' => 5, 'status' => 'occupied', 'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=400&h=300&fit=crop'],
                                ['code' => 'FA305', 'beds' => 6, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop'],
                                ['code' => 'HA694', 'beds' => 7, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=400&h=300&fit=crop'],
                                ['code' => 'SA888', 'beds' => 8, 'status' => 'occupied', 'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=400&h=300&fit=crop'],
                                ['code' => 'NA265', 'beds' => 9, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop'],
                                ['code' => 'PA409', 'beds' => 9, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=400&h=300&fit=crop'],
                                ['code' => 'DA941', 'beds' => 2, 'status' => 'occupied', 'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=400&h=300&fit=crop'],
                                ['code' => 'KA176', 'beds' => 11, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop'],
                                ['code' => 'GA528', 'beds' => 12, 'status' => 'available', 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=400&h=300&fit=crop'],
                            ];
                        @endphp

                        @foreach ($rooms as $room)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-12 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                                            <img src="{{ $room['image'] }}" alt="Phòng {{ $room['code'] }}" 
                                                 class="w-full h-full object-cover" 
                                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNDgiIHZpZXdCb3g9IjAgMCA2NCA0OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjQ4IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xNiAxNkg0OFY0MEgxNlYxNloiIGZpbGw9IiNEN0Q5REIiLz4KPHBhdGggZD0iTTIwIDIwSDQ0VjM2SDIwVjIwWiIgZmlsbD0iI0U1RTdFQSIvPgo8L3N2Zz4K'">
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900">{{ $room['code'] }}</div>
                                            <div class="text-sm text-gray-500">Phòng bệnh</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <i class="ph ph-bed text-blue-600"></i>
                                        <span class="text-lg font-semibold text-gray-900">{{ $room['beds'] }}</span>
                                        <span class="text-sm text-gray-500">giường</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($room['status'] === 'available')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                            <i class="ph ph-check-circle mr-1"></i>
                                            Còn trống
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                            <i class="ph ph-x-circle mr-1"></i>
                                            Đã đầy
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($room['status'] === 'available')
                                          
                                        @else
                                            <span class="text-gray-400 font-semibold">
                                                <i class="ph ph-lock mr-1"></i>
                                                Không khả dụng
                                            </span>
                                        @endif
                                        <button onclick="viewRoomDetails('{{ $room['code'] }}')" 
                                                class="text-gray-600 hover:text-gray-800 font-semibold transition-colors duration-200">
                                            <i class="ph ph-eye mr-1"></i>
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Room Details Modal -->
        <div id="roomModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-800" id="modalTitle">Chi tiết phòng</h3>
                            <button onclick="closeRoomModal()" class="text-gray-400 hover:text-gray-600">
                                <i class="ph ph-x text-2xl"></i>
                            </button>
                        </div>
                        
                        <div id="modalContent">
                            <!-- Content will be loaded here -->
                        </div>
                        
                        <div class="flex justify-end gap-3 mt-6">
                            <button onclick="closeRoomModal()" 
                                    class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors duration-200">
                                Đóng
                            </button>
                            <button id="selectRoomBtn" onclick="confirmRoomSelection()" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                Chọn phòng này
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-center gap-4 mt-8">
            
            
            <a href="{{ route('patients.hospitalization') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-300">
                <i class="ph ph-calendar"></i>
                Lịch sử nhập viện
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 Bệnh viện Heruko. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

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

        // Room selection functions
        let selectedRoomCode = null;

        function selectRoom(roomCode) {
            selectedRoomCode = roomCode;
            alert(`Bạn đã chọn phòng ${roomCode}. Vui lòng liên hệ nhân viên y tế để hoàn tất thủ tục nhập viện.`);
        }

        function viewRoomDetails(roomCode) {
            selectedRoomCode = roomCode;
            
            // Dữ liệu chi tiết phòng
            const roomDetails = {
                'MA759': {
                    name: 'Phòng MA759',
                    beds: 6,
                    status: 'Còn trống',
                    description: 'Phòng bệnh tiêu chuẩn với 6 giường, đầy đủ tiện nghi cơ bản.',
                    facilities: ['Điều hòa', 'TV', 'Tủ đựng đồ', 'Nhà vệ sinh riêng'],
                    image: 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=600&h=400&fit=crop'
                },
                'BA123': {
                    name: 'Phòng BA123',
                    beds: 7,
                    status: 'Còn trống',
                    description: 'Phòng bệnh rộng rãi với 7 giường, phù hợp cho điều trị dài ngày.',
                    facilities: ['Điều hòa', 'TV', 'Tủ đựng đồ', 'Nhà vệ sinh riêng', 'Tủ lạnh mini'],
                    image: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?w=600&h=400&fit=crop'
                }
                // Thêm các phòng khác...
            };

            const room = roomDetails[roomCode] || {
                name: `Phòng ${roomCode}`,
                beds: 5,
                status: 'Còn trống',
                description: 'Phòng bệnh tiêu chuẩn với đầy đủ tiện nghi cơ bản.',
                facilities: ['Điều hòa', 'TV', 'Tủ đựng đồ', 'Nhà vệ sinh riêng'],
                image: 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=600&h=400&fit=crop'
            };

            document.getElementById('modalTitle').textContent = room.name;
            document.getElementById('modalContent').innerHTML = `
                <div class="space-y-6">
                    <div class="aspect-video rounded-lg overflow-hidden bg-gray-100">
                        <img src="${room.image}" alt="${room.name}" class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDYwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI2MDAiIGhlaWdodD0iNDAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xNjAgMTYwSDQ4MFYzMjBIMTYwVjE2MFoiIGZpbGw9IiNEN0Q5REIiLz4KPHBhdGggZD0iTTIwMCAyMDBINDAwVjI4MEgyMDBWMjAwWiIgZmlsbD0iI0U1RTdFQSIvPgo8L3N2Zz4K'">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Thông tin phòng</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Mã phòng:</span>
                                    <span class="font-semibold">${roomCode}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Số giường:</span>
                                    <span class="font-semibold">${room.beds}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Trạng thái:</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">${room.status}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Tiện nghi</h4>
                            <div class="space-y-2">
                                ${room.facilities.map(facility => `
                                    <div class="flex items-center gap-2">
                                        <i class="ph ph-check text-green-600"></i>
                                        <span class="text-gray-700">${facility}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Mô tả</h4>
                        <p class="text-gray-600 leading-relaxed">${room.description}</p>
                    </div>
                </div>
            `;

            document.getElementById('roomModal').classList.remove('hidden');
        }

        function closeRoomModal() {
            document.getElementById('roomModal').classList.add('hidden');
        }

        function confirmRoomSelection() {
            if (selectedRoomCode) {
                alert(`Bạn đã chọn phòng ${selectedRoomCode}. Vui lòng liên hệ nhân viên y tế để hoàn tất thủ tục nhập viện.`);
                closeRoomModal();
            }
        }

        // Close modal when clicking outside
        document.getElementById('roomModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRoomModal();
            }
        });
    </script>

</body>
</html>

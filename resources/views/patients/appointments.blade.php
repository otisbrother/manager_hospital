<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Hẹn - Bệnh viện Heruko</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
    {{-- Header --}}
    <header class="bg-white shadow-lg border-b-4 border-blue-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <i class="ph ph-hospital text-blue-600 text-3xl"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Bệnh viện Heruko</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Xin chào, {{ session('patient_name', 'Bệnh nhân') }}</span>
                    <a href="{{ route('patient.home') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center gap-2">
                        <i class="ph ph-house"></i>
                        Trang chủ
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Page Title --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="ph ph-calendar-check text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Lịch khám Của Tôi</h1>
                        <p class="text-gray-600">Xem tất cả lịch khám khám bệnh</p>
                    </div>
                </div>
                <a href="{{ route('patient.appointment.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors duration-300 flex items-center gap-2">
                    <i class="ph ph-plus"></i>
                    Đặt lịch mới
                </a>
            </div>
        </div>

        {{-- Appointments List --}}
        @if($appointments->count() > 0)
            <div class="space-y-6">
                @foreach($appointments as $appointment)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                {{-- Appointment Info --}}
                                <div class="flex-1">
                                    <div class="flex items-start gap-4">
                                        {{-- Status Badge --}}
                                        <div class="flex-shrink-0">
                                            @switch($appointment->status)
                                                @case('pending')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="ph ph-clock mr-1"></i>
                                                        Chờ xác nhận
                                                    </span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <i class="ph ph-check-circle mr-1"></i>
                                                        Đã xác nhận
                                                    </span>
                                                    @break
                                                @case('completed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <i class="ph ph-check-square mr-1"></i>
                                                        Hoàn thành
                                                    </span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <i class="ph ph-x-circle mr-1"></i>
                                                        Đã hủy
                                                    </span>
                                                    @break
                                            @endswitch
                                        </div>

                                        {{-- Main Info --}}
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                                <i class="ph ph-calendar text-blue-600 mr-2"></i>
                                                Lịch khám #{{ $appointment->id }}
                                            </h3>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                                <div class="space-y-2">
                                                    <div class="flex items-center">
                                                        <i class="ph ph-calendar-blank text-blue-500 mr-2"></i>
                                                        <span class="font-medium">Ngày hẹn:</span>
                                                        <span class="ml-2 font-semibold text-gray-800">
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}
                                                        </span>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <i class="ph ph-stethoscope text-green-500 mr-2"></i>
                                                        <span class="font-medium">Bác sĩ:</span>
                                                        <span class="ml-2">{{ $appointment->doctor->name ?? 'Chưa phân công' }}</span>
                                                    </div>
                                                </div>

                                                <div class="space-y-2">
                                                    <div class="flex items-center">
                                                        <i class="ph ph-building text-purple-500 mr-2"></i>
                                                        <span class="font-medium">Khoa:</span>
                                                        <span class="ml-2">{{ $appointment->department->name ?? 'Chưa rõ' }}</span>
                                                    </div>

                                                    <div class="flex items-center">
                                                        <i class="ph ph-clock text-orange-500 mr-2"></i>
                                                        <span class="font-medium">Đặt lúc:</span>
                                                        <span class="ml-2">{{ $appointment->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Symptoms --}}
                                            @if($appointment->symptoms)
                                                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                                    <div class="flex items-start">
                                                        <i class="ph ph-note text-blue-500 mr-2 mt-0.5"></i>
                                                        <div>
                                                            <span class="font-medium text-gray-700">Triệu chứng:</span>
                                                            <p class="text-gray-600 mt-1">{{ $appointment->symptoms }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Notes --}}
                                            @if($appointment->notes)
                                                <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                                    <div class="flex items-start">
                                                        <i class="ph ph-info text-blue-500 mr-2 mt-0.5"></i>
                                                        <div>
                                                            <span class="font-medium text-blue-700">Ghi chú:</span>
                                                            <p class="text-blue-600 mt-1">{{ $appointment->notes }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-col sm:flex-row gap-3 lg:ml-4">
                                    @if($appointment->status === 'pending')
                                        <div class="text-center">
                                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                                <i class="ph ph-hourglass text-yellow-600 text-xl mb-1"></i>
                                                <p class="text-xs text-yellow-700 font-medium">Chờ bệnh viện xác nhận</p>
                                            </div>
                                        </div>
                                    @elseif($appointment->status === 'confirmed')
                                        <div class="text-center">
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                                <i class="ph ph-calendar-check text-blue-600 text-xl mb-1"></i>
                                                <p class="text-xs text-blue-700 font-medium">Đã được xác nhận</p>
                                                <p class="text-xs text-blue-600 mt-1">Vui lòng đến đúng giờ</p>
                                            </div>
                                        </div>
                                    @elseif($appointment->status === 'completed')
                                        <div class="text-center">
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                                <i class="ph ph-check-circle text-green-600 text-xl mb-1"></i>
                                                <p class="text-xs text-green-700 font-medium">Đã hoàn thành</p>
                                            </div>
                                        </div>
                                    @elseif($appointment->status === 'cancelled')
                                        <div class="text-center">
                                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                <i class="ph ph-x-circle text-red-600 text-xl mb-1"></i>
                                                <p class="text-xs text-red-700 font-medium">Đã bị hủy</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Timeline footer --}}
                        <div class="bg-gray-50 px-6 py-3 border-t">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>Mã lịch khám: <strong class="text-gray-700">#{{ $appointment->id }}</strong></span>
                                <span>Cập nhật: {{ $appointment->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination if needed --}}
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-lg shadow px-6 py-3">
                    <p class="text-gray-600">Tổng cộng: <strong class="text-blue-600">{{ $appointments->count() }}</strong> lịch hẹn</p>
                </div>
            </div>

        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="ph ph-calendar-x text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Chưa có lịch khám nào</h3>
                    <p class="text-gray-600 mb-6">Bạn chưa đặt lịch hẹn khám bệnh nào. Hãy đặt lịch để được bác sĩ tư vấn và khám chữa bệnh.</p>
                    <a href="{{ route('patient.appointment.create') }}" 
                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-300 gap-2">
                        <i class="ph ph-plus"></i>
                        Đặt lịch khám đầu tiên
                    </a>
                </div>
            </div>
        @endif
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <i class="ph ph-hospital text-2xl"></i>
                <span class="text-xl font-bold">Bệnh viện Heruko</span>
            </div>
            <p class="text-gray-400">Chăm sóc sức khỏe - Phục vụ tận tâm</p>
        </div>
    </footer>
</body>
</html> 
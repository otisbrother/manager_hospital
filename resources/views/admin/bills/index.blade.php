<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            📄 Danh sách Hóa Đơn Viện Phí
        </h2>
    </x-slot>
@section('content')
<div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
    <div class="py-6 px-6 bg-white rounded shadow">
       

        <!-- Form tìm kiếm đơn giản -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
            <form method="GET" action="{{ route('admin.bills.index') }}" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Nhập mã hóa đơn, mã bệnh nhân, mã đơn thuốc hoặc mã BHYT...">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        🔍 Tìm kiếm
                    </button>
                    <a href="{{ route('admin.bills.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        🔄 Làm mới
                    </a>
                </div>
            </form>
        </div>

        <!-- Hiển thị kết quả tìm kiếm -->
        @if(request()->hasAny(['search', 'status']))
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">
                    🔍 Kết quả tìm kiếm: {{ $bills->total() }} hóa đơn được tìm thấy
                    @if(request('search'))
                        cho từ khóa "{{ request('search') }}"
                    @endif
                    @if(request('status'))
                        với trạng thái "{{ request('status') == 'pending' ? 'Chờ thanh toán' : (request('status') == 'paid' ? 'Đã thanh toán' : 'Đã hủy') }}"
                    @endif
                </p>
            </div>
        @endif

        <table class="table-auto w-full mt-4">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Mã Hóa Đơn</th>
                    <th class="px-4 py-2">Mã BHYT</th>
                    <th class="px-4 py-2">Mã Bệnh Nhân</th>
                    <th class="px-4 py-2">Mã Đơn Thuốc</th>
                    <th class="px-4 py-2">Tổng Tiền</th>
                    <th class="px-4 py-2">Trạng Thái</th>
                    <th class="px-4 py-2">Ngày Tạo</th>
                    <th class="px-4 py-2">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bills as $bill)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium">{{ $bill->id }}</td>
                        <td class="px-4 py-2">
                            @if($bill->health_insurance_id)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ $bill->health_insurance_id }}</span>
                            @else
                                <span class="text-gray-400 text-xs">Không có</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $bill->patient_id }}</td>
                        <td class="px-4 py-2">
                            @if($bill->prescription_id)
                                {{ $bill->prescription_id }}
                            @else
                                <span class="text-gray-400 text-xs">Không có</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 font-semibold text-green-600">{{ number_format($bill->total, 0, ',', '.') }} ₫</td>
                        <td class="px-4 py-2">
                            @if($bill->status == 'paid')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Đã thanh toán</span>
                            @elseif($bill->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Chờ thanh toán</span>
                            @elseif($bill->status == 'cancelled')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Đã hủy</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">{{ $bill->status ?? 'Chưa xác định' }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-600">{{ $bill->created_at ? $bill->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td class="px-4 py-2">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.bills.edit', $bill->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">✏️ Sửa</a>
                                <form action="{{ route('admin.bills.destroy', $bill->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">🗑️ Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <span class="text-4xl mb-2">📄</span>
                                <p>Không tìm thấy hóa đơn nào</p>
                                                @if(request()->hasAny(['search', 'status']))
                    <p class="text-sm mt-1">Thử thay đổi tiêu chí tìm kiếm</p>
                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Phân trang -->
        @if($bills->hasPages())
            <div class="mt-6">
                {{ $bills->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>


    
@endsection  
</x-app-layout>
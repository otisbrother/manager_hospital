<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">📋 Danh sách Bệnh nhân</h2>

    </x-slot>
    @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
        
   
    <div class="py-10 px-6 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1>*Lưu ý tìm kiếm theo tên bệnh nhân hoặc mã bệnh nhân để chính xác nhất</h1>
            {{-- Form tìm kiếm đơn giản --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <div class="flex justify-between items-center">
                    <div class="flex-1 max-w-md">
                        <form method="GET" action="{{ route('admin.patients.index') }}" class="flex">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="🔍 Tìm theo địa chỉ, SĐT, mã BN, mã BHYT, họ tên..."
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-r-lg hover:bg-blue-700 transition">
                                🔍 Tìm
                            </button>
                        </form>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <a href="{{ route('admin.patients.index') }}"
                           class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600 transition">
                            🔄 Làm mới
                        </a>
                        <a href="{{ route('admin.patients.create') }}"
                           class="px-4 py-2 bg-green-600 text-black font-semibold rounded-md hover:bg-green-700 transition">
                            ➕ Thêm bệnh nhân
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kết quả tìm kiếm --}}
            @if(request('search'))
                <div class="mb-4">
                    @if($patients->count() > 0)
                        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md">
                            <strong>✅ Tìm thấy {{ $patients->total() }} bệnh nhân</strong> cho từ khóa "{{ request('search') }}"
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md">
                            <strong>❌ Không tìm thấy bệnh nhân nào</strong> cho từ khóa "{{ request('search') }}"
                        </div>
                    @endif
                </div>
            @endif

            {{-- Bảng dữ liệu --}}
            <div class="bg-white shadow rounded-xl overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-gray-800">
                    <thead class="bg-blue-100 text-left text-xs font-bold">
                        <tr>
                            <th class="px-4 py-3">Mã BN</th>
                            <th class="px-4 py-3">Loại BN</th>
                            <th class="px-4 py-3">Mã BHYT</th>
                            <th class="px-4 py-3">Họ tên</th>
                            <th class="px-4 py-3">Giới tính</th>
                            <th class="px-4 py-3">Ngày sinh</th>
                            <th class="px-4 py-3">Địa chỉ</th>
                            <th class="px-4 py-3">SĐT</th>
                            <th class="px-4 py-3">Tạo lúc</th>
                            <th class="px-4 py-3">Cập nhật</th>
                            <th class="px-4 py-3 text-center">⚙️</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($patients as $patient)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $patient->id }}</td>
                                <td class="px-4 py-2">{{ $patient->typePatient->name ?? $patient->patient_type_id }}</td>
                                <td class="px-4 py-2">{{ $patient->insurance_id }}</td>
                                <td class="px-4 py-2">{{ $patient->name }}</td>
                                <td class="px-4 py-2">{{ $patient->gender }}</td>
                                <td class="px-4 py-2">{{ $patient->date }}</td>
                                <td class="px-4 py-2">{{ $patient->address }}</td>
                                <td class="px-4 py-2">{{ $patient->phone }}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->created_at }}</td>
                                <td class="px-4 py-2 text-xs">{{ $patient->updated_at }}</td>
                                <td class="px-4 py-2 text-center space-x-1">
                                    <a href="{{ route('admin.patients.show', $patient->id) }}"
                                       class="text-blue-600 hover:underline" title="Xem chi tiết">🔍</a>
                                    <a href="{{ route('admin.patients.edit', $patient->id) }}"
                                       class="text-yellow-500 hover:underline" title="Chỉnh sửa">✏️</a>
                                    <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xoá bệnh nhân này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" title="Xóa">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4 text-gray-500">
                                    Không có dữ liệu bệnh nhân.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Phân trang --}}
            <div class="mt-6">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
     </div>
    @endsection
</x-app-layout>

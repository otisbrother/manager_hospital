<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Danh sách thuốc</h2>
    </x-slot>
    @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
 <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Nút thêm thuốc --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.medicines.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-black font-semibold px-4 py-2 rounded shadow">
                    + Thêm thuốc
                </a>
            </div>

            {{-- Bảng --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full w-full text-sm text-left text-gray-800">
                    <thead class="bg-gray-100 uppercase text-sm text-gray-600">
                        <tr>
                            <th class="px-6 py-3 w-[8%]">Mã</th>
                            <th class="px-6 py-3 w-[20%]">Tên thuốc</th>
                            <th class="px-6 py-3 w-[28%]">Công dụng</th>
                            <th class="px-6 py-3 w-[10%]">Đơn vị</th>
                            <th class="px-6 py-3 w-[12%]">HSD</th>
                            <th class="px-6 py-3 w-[12%]">Giá</th>
                            <th class="px-6 py-3 w-[10%] text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($medicines as $medicine)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $medicine->id }}</td>
                                <td class="px-6 py-3">{{ $medicine->name }}</td>
                                <td class="px-6 py-3">{{ $medicine->usage }}</td>
                                <td class="px-6 py-3">{{ $medicine->unit }}</td>
                                <td class="px-6 py-3">{{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d/m/Y') }}</td>
                                <td class="px-6 py-3">{{ number_format($medicine->price, 0, ',', '.') }}₫</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('admin.medicines.edit', $medicine->id) }}"
                                           class="text-blue-600 hover:underline font-medium">Sửa</a>
                                        <form action="{{ route('admin.medicines.destroy', $medicine->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Xoá thuốc này?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:underline font-medium">
                                                Xoá
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Không có thuốc nào trong hệ thống.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 
    </div>
   
    @endsection
</x-app-layout>

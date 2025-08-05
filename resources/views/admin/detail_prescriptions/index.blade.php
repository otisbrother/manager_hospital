<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Chi tiết đơn thuốc</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.detail-prescriptions.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded shadow">
                    + Thêm chi tiết
                </a>
            </div>

           <div class="bg-white shadow rounded overflow-x-auto">
    <table class="w-full table-auto text-sm text-left text-gray-800">
                    <thead class="bg-gray-100 uppercase text-gray-600">
                        <tr>
                            <th class="px-6 py-3">Mã đơn thuốc</th>
                            <th class="px-6 py-3">Mã thuốc</th>
                            <th class="px-6 py-3">Số lượng</th>
                            <th class="px-6 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($details as $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $detail->prescription_id }}</td>
                                <td class="px-6 py-3">{{ $detail->medicine_id }}</td>
                                <td class="px-6 py-3">{{ $detail->quantity }}</td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('admin.detail-prescriptions.edit', [$detail->prescription_id, $detail->medicine_id]) }}"
                                           class="text-indigo-600 hover:underline font-medium">Sửa</a>
                                        <form action="{{ route('admin.detail-prescriptions.destroy', [$detail->prescription_id, $detail->medicine_id]) }}"
                                              method="POST" onsubmit="return confirm('Xoá chi tiết này?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline font-medium">Xoá</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Không có dữ liệu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 
    @endsection
</x-app-layout>

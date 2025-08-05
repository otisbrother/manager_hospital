<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">📋 Danh sách đơn thuốc</h2>
    </x-slot>
    @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
       <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 space-y-6">

            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                {{-- Nút thêm mới --}}
                <div class="flex justify-end">
                    <a href="{{ route('admin.prescriptions.create') }}"
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-black px-5 py-2 rounded-md shadow">
                        <span class="text-lg">➕</span>
                        <span>Thêm đơn thuốc</span>
                    </a>
                </div>

                {{-- Bảng danh sách --}}
              
           <div class="bg-white shadow rounded overflow-x-auto">
    <table class="w-full table-auto text-sm text-left text-gray-800">
                        <thead class="bg-gray-100 text-gray-600 uppercase">
                            <tr>
                                <th class="px-6 py-3">Mã đơn thuốc</th>
                                <th class="px-6 py-3">Mã BS</th>
                                <th class="px-6 py-3">Mã BN</th>
                                <th class="px-6 py-3">Ngày tạo</th>
                                <th class="px-6 py-3 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($prescriptions as $prescription)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-3">{{ $prescription->id }}</td>
                                    <td class="px-6 py-3">{{ $prescription->doctor_id }}</td>
                                    <td class="px-6 py-3">{{ $prescription->patient_id }}</td>
                                    <td class="px-6 py-3">{{ $prescription->created_at->format('d/m/Y') }}</td>
                                    <td class="px-6 py-3 text-center">
                                        <div class="flex justify-center space-x-3">
                                            <a href="{{ route('admin.prescriptions.show', $prescription->id) }}"
                                               class="text-blue-600 hover:underline">Xem</a>
                                            <a href="{{ route('admin.prescriptions.edit', $prescription->id) }}"
                                               class="text-indigo-600 hover:underline">Sửa</a>
                                            <form action="{{ route('admin.prescriptions.destroy', $prescription->id) }}"
                                                  method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá?')" class="inline-block">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Xoá</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Không có đơn thuốc nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    </div>
    
    @endsection
</x-app-layout>

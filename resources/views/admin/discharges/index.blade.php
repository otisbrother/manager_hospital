<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Danh sách xuất viện</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.discharges.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded shadow">
                    + Thêm xuất viện
                </a>
            </div>

            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full w-full text-sm text-left text-gray-800">
                    <thead class="bg-gray-100 uppercase text-gray-600">
                        <tr>
                            <th class="px-6 py-3">Mã BN</th>
                            <th class="px-6 py-3">Tên bệnh nhân</th>
                            <th class="px-6 py-3">Ngày xuất viện</th>
                            <th class="px-6 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($discharges as $d)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $d->patient_id }}</td>
                                <td class="px-6 py-3">{{ $d->patient->name ?? 'Không rõ' }}</td>
                                <td class="px-6 py-3">{{ $d->discharge_date }}</td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('admin.discharges.edit', [$d->patient_id, $d->discharge_date]) }}"
                                           class="text-indigo-600 hover:underline font-medium">Sửa</a>
                                        <form action="{{ route('admin.discharges.destroy', [$d->patient_id, $d->discharge_date]) }}"
                                              method="POST" onsubmit="return confirm('Xoá thông tin này?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline font-medium">Xoá</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">Không có dữ liệu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>

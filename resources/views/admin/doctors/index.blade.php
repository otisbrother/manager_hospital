<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Danh sách bác sĩ</h2>
    </x-slot>
    @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Nút Thêm --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.doctors.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded shadow">
                    + Thêm bác sĩ
                </a>
            </div>

            {{-- Bảng --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 uppercase text-sm text-gray-600">
                        <tr>
                            <th class="px-6 py-3 w-1/12">Mã BS</th>
                            <th class="px-6 py-3 w-3/12">Tên</th>
                            <th class="px-6 py-3 w-2/12">Giới tính</th>
                            <th class="px-6 py-3 w-4/12">Khoa</th>
                            <th class="px-6 py-3 w-2/12">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($doctors as $doctor)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $doctor->id }}</td>
                                <td class="px-6 py-4">{{ $doctor->name }}</td>
                                <td class="px-6 py-4">{{ $doctor->gender }}</td>
                                <td class="px-6 py-4">{{ $doctor->department->name ?? '---' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.doctors.edit', $doctor->id) }}"
                                           class="text-blue-600 hover:underline font-medium">Sửa</a>
                                        <form action="{{ route('admin.doctors.destroy', $doctor->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Bạn có chắc muốn xoá?')">
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
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Không có bác sĩ nào trong hệ thống.
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

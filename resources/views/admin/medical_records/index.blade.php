<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">📄 Danh sách sổ khám bệnh</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.medical-records.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded shadow">
                    ➕ Thêm sổ khám bệnh
                </a>
            </div>

    
           <div class="bg-white shadow rounded overflow-x-auto">
    <table class="w-full table-auto text-sm text-left text-gray-800">
                    <thead class="bg-gray-100 text-gray-600 uppercase">
                        <tr>
                            <th class="px-6 py-3">Mã sổ khám</th>
                            <th class="px-6 py-3">STT</th>
                            <th class="px-6 py-3 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($records as $record)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-2">{{ $record->id }}</td>
                                <td class="px-6 py-2">{{ $record->order }}</td>
                                <td class="px-6 py-2 text-center space-x-2">
                                    <a href="{{ route('admin.medical-records.show', [$record->id, $record->order]) }}"
                                       class="text-blue-600 hover:underline">Xem</a>
                                    <a href="{{ route('admin.medical-records.edit', [$record->id, $record->order]) }}"
                                       class="text-indigo-600 hover:underline">Sửa</a>
                                    <form action="{{ route('admin.medical-records.destroy', [$record->id, $record->order]) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Xác nhận xoá?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if($records->isEmpty())
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Không có dữ liệu.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>

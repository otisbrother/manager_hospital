<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📂 Danh sách loại bệnh nhân</h2>
    </x-slot>
    @section('content')
    <div class="py-6 max-w-4xl mx-auto">
        <a href="{{ route('admin.type_patients.create') }}" 
           class="bg-blue-600 text-black px-4 py-2 rounded shadow hover:bg-blue-700 mb-4 inline-block">
            + Thêm loại bệnh nhân
        </a>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border bg-white shadow rounded text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Mã</th>
                    <th class="px-4 py-2 text-left">Tên</th>
                    <th class="px-4 py-2 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($types as $type)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $type->id }}</td>
                        <td class="px-4 py-2">{{ $type->name }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('admin.type_patients.edit', $type->id) }}" class="text-yellow-500 font-semibold">Sửa</a>
                            <form action="{{ route('admin.type_patients.destroy', $type->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 ml-2 font-semibold">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
</x-app-layout>

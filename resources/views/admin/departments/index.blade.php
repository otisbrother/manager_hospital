<x-app-layout>  
    <x-slot name="header">
        <h2 class="text-xl font-bold">📋 Danh sách Khoa</h2>
    </x-slot>
  @section('content')
  <a href="{{ route('admin.departments.create') }}"
   class="inline-block bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded shadow transition duration-200">
    + Thêm Khoa
</a>


    @if(session('success'))
        <div class="text-green-500">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Mã khoa</th>
                <th class="px-4 py-2">Tên khoa</th>
                <th class="px-4 py-2">Vị trí</th>
                <th class="px-4 py-2">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $dept)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $dept->id }}</td>
                <td class="px-4 py-2">{{ $dept->name }}</td>
                <td class="px-4 py-2">{{ $dept->location }}</td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.departments.edit', $dept->id) }}" class="text-yellow-500">Sửa</a>
                    <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa khoa này?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 ml-2">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
</x-app-layout>
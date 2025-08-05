<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            👨‍👩‍👧‍👦 Danh sách Thân nhân
        </h2>
    </x-slot>
    @section('content')
    <div class="py-6 px-6 bg-white rounded shadow">

        {{-- Nút thêm mới --}}
        <a href="{{ route('admin.relatives.create') }}"
           class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
            ➕ Thêm mới thân nhân
        </a>

        {{-- Bảng --}}
        <div class="overflow-x-auto mt-4">
            <table class="w-full border text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">Mã BN</th>
                        <th class="border px-3 py-2">Họ tên</th>
                        <th class="border px-3 py-2">Giới tính</th>
                        <th class="border px-3 py-2">Ngày sinh</th>
                        <th class="border px-3 py-2">Quan hệ</th>
                        <th class="border px-3 py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($relatives as $r)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-1">{{ $r->patient_id }}</td>
                            <td class="border px-3 py-1">{{ $r->name }}</td>
                            <td class="border px-3 py-1">{{ $r->gender }}</td>
                            <td class="border px-3 py-1">{{ \Carbon\Carbon::parse($r->dob)->format('d/m/Y') }}</td>
                            <td class="border px-3 py-1">{{ $r->relationship }}</td>
                           <td class="border px-3 py-1 text-sm space-x-2">
<a href="{{ route('admin.relatives.show', ['patient_id' => $r->patient_id, 'name' => $r->name]) }}" class="text-blue-600 hover:underline">Xem</a>

<a href="{{ route('admin.relatives.edit', ['patient_id' => $r->patient_id, 'name' => $r->name]) }}" class="text-yellow-600 hover:underline">Sửa</a>

<form action="{{ route('admin.relatives.destroy', ['patient_id' => $r->patient_id, 'name' => $r->name]) }}" method="POST" class="inline-block" onsubmit="return confirm('Xác nhận xóa?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:underline">Xóa</button>
</form>




</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">Không có dữ liệu thân nhân.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection
</x-app-layout>


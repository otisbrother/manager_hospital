<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-purple-700">📋 Danh sách lịch hẹn</h2>
    </x-slot>
        @section('content')
    <div class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">
    
    <div class="p-6 w-full max-w-full">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
<!-- 
        {{-- Nút tạo mới --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.appointments.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                ➕ Tạo lịch hẹn mới
            </a>
        </div> -->
        <!-- 🔍 Form tìm kiếm -->

<form method="GET" action="{{ route('admin.appointments.index') }}" class="mb-4 flex items-center gap-2">
    <div class="relative w-2/3 max-w-xl">
        <!-- Icon kính lúp -->
        <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Tìm kiếm theo Mã BN, Mã BS, Khoa, Ngày, Triệu chứng..."
               class="pl-10 border p-2 rounded-lg w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
    </div>
    <button type="submit" class="bg-purple-600 text-black px-5 py-2 rounded-lg shadow hover:bg-purple-700">
        Tìm kiếm
    </button>
</form>



        {{-- Bảng lịch hẹn --}}
        <div class="overflow-x-auto bg-white rounded shadow w-full">
            <table class="w-full table-auto text-left border">
                <thead class="bg-indigo-100 text-indigo-700 font-bold">
                    <tr>
                        <th class="px-4 py-2">STT</th>
                        <th class="px-4 py-2">Mã BN</th>
                        <th class="px-4 py-2">Mã BS</th>
                        <th class="px-4 py-2">Mã Khoa</th>
                        <th class="px-4 py-2">Ngày hẹn</th>
                        <th class="px-4 py-2">Triệu chứng</th>
                        <th class="px-4 py-2">Trạng thái</th>
                        <th class="px-4 py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appointments as $index => $item)
                        <tr class="border-t">
                       <td class="px-4 py-2">{{ $index + 1 }}</td>
<td class="px-4 py-2">{{ $item->patient_id ?? 'N/A' }}</td>
<td class="px-4 py-2">{{ $item->doctor_id ?? 'Chưa phân công' }}</td>
<td class="px-4 py-2">{{ $item->department_id ?? 'Chưa rõ' }}</td>
<td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->appointment_date)->format('d/m/Y H:i') }}</td>
<td class="px-4 py-2">{{ $item->symptoms ?? 'Không rõ' }}</td>

<td class="px-4 py-2">
    <select onchange="updateStatus(this, {{ $item->id }})"
            class="text-sm rounded px-2 py-1 border focus:outline-none
            {{ match($item->status) {
                'pending' => 'bg-yellow-100 text-yellow-700',
                'confirmed' => 'bg-blue-100 text-blue-700',
                'completed' => 'bg-green-100 text-green-700',
                'cancelled' => 'bg-red-100 text-red-700',
                default => 'bg-gray-100 text-gray-700'
            } }}">
        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Đang chờ</option>
        <option value="confirmed" {{ $item->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
        <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
    </select>
</td>


                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.appointments.show', $item->id) }}"
                                   class="text-indigo-600 hover:underline">🔍</a>
                                <a href="{{ route('admin.appointments.edit', $item->id) }}"
                                   class="text-yellow-600 hover:underline">✏️</a>
                                <form action="{{ route('admin.appointments.destroy', $item->id) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center px-4 py-6 text-gray-500">Chưa có lịch hẹn nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Phân trang --}}
        <div class="mt-6">
            {{ $appointments->links() }}
        </div>
    </div>
    <script>
function updateStatus(selectElement, appointmentId) {
    const status = selectElement.value;

    fetch(`/admin/appointments/${appointmentId}/update-status`, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("✅ Trạng thái đã cập nhật!");
        } else {
            alert("❌ Cập nhật thất bại.");
        }
    })
    .catch(error => {
        alert("⚠️ Có lỗi khi gửi yêu cầu.");
        console.error("Lỗi:", error);
    });
}
</script>

    </div>
    @endsection
  
</x-app-layout>

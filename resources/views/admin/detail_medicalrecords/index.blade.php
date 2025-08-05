<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            📄 Danh sách chi tiết sổ khám bệnh
        </h2>
    </x-slot>
    @section('content')
    <div class="py-6 px-6 bg-white rounded shadow">
        <a href="{{ route('admin.detail-medicalrecords.create') }}" class="px-4 py-2 bg-purple-600 text-black rounded hover:bg-purple-700 mb-4 inline-block">
            ➕ Thêm chi tiết
        </a>

        <table class="table-auto w-full mt-4">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Mã Sổ</th>
                    <th class="px-4 py-2">Mã Bệnh Nhân</th>
                    <th class="px-4 py-2">Ngày Khám</th>
                    <th class="px-4 py-2">Mã Đơn Thuốc</th>
                    <th class="px-4 py-2">Tên Bệnh</th>
                    <th class="px-4 py-2">Mã Khoa</th>
                    <th class="px-4 py-2">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicalDetails as $detail)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $detail->medical_record_id }}</td>
                        <td class="px-4 py-2">{{ $detail->patient_id }}</td>
                        <td class="px-4 py-2">{{ $detail->exam_date }}</td>
                        <td class="px-4 py-2">{{ $detail->prescription_id }}</td>
                        <td class="px-4 py-2">{{ $detail->disease_name }}</td>
                        <td class="px-4 py-2">{{ $detail->department_id }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.detail-medicalrecords.edit', [$detail->medical_record_id, $detail->patient_id, $detail->exam_date]) }}" class="text-yellow-600 hover:underline">Sửa</a>
                            <form action="{{ route('admin.detail-medicalrecords.destroy', [$detail->medical_record_id, $detail->patient_id, $detail->exam_date]) }}" method="POST" class="inline-block" onsubmit="return confirm('Xoá bản ghi này?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection
</x-app-layout>

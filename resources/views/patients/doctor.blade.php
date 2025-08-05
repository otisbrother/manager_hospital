<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách bác sĩ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
            <i class="ph ph-stethoscope text-blue-600 text-4xl"></i> Danh sách bác sĩ
        </h1>

        <a href="{{ route('patient.home') }}" 
           class="mt-4 sm:mt-0 inline-block text-blue-600 hover:text-blue-800 font-medium transition duration-200">
            ← Quay về trang chủ
        </a>
    </div>
</div>


        <div class="overflow-x-auto rounded-xl shadow-lg bg-white">
            <table class="min-w-full text-sm text-gray-700 text-left border-collapse">
                <thead class="bg-blue-100 text-gray-800 text-sm">
                    <tr>
                        <th class="px-4 py-3">Ảnh</th>
                        <th class="px-4 py-3">Mã BS</th>
                        <th class="px-4 py-3">Tên</th>
                        <th class="px-4 py-3">Giới tính</th>
                        <th class="px-4 py-3">Khoa</th>
                        <th class="px-4 py-3">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $doctors = [
                            ['id' => 'BS001', 'name' => 'Trần Minh Huy', 'gender' => 'Nam', 'department' => 'Khoa Nội khoa'],
                            ['id' => 'BS002', 'name' => 'Nguyễn Thị Kim Anh', 'gender' => 'Nữ', 'department' => 'Khoa Ngoại khoa'],
                            ['id' => 'BS003', 'name' => 'Lê Văn Tùng', 'gender' => 'Nam', 'department' => 'Khoa Tai mũi họng'],
                            ['id' => 'BS004', 'name' => 'Phạm Thị Mai', 'gender' => 'Nữ', 'department' => 'Khoa Răng Hàm Mặt'],
                            ['id' => 'BS005', 'name' => 'Đặng Quang Tú', 'gender' => 'Nam', 'department' => 'Khoa Mắt'],
                            ['id' => 'BS006', 'name' => 'Võ Thị Lan Anh', 'gender' => 'Nữ', 'department' => 'Khoa Sản'],
                            ['id' => 'BS007', 'name' => 'Hoàng Minh Tuấn', 'gender' => 'Nam', 'department' => 'Khoa Nhi'],
                            ['id' => 'BS008', 'name' => 'Lý Mai Linh', 'gender' => 'Nữ', 'department' => 'Khoa Tim mạch'],
                            ['id' => 'BS009', 'name' => 'Mai Văn Hiệu', 'gender' => 'Nam', 'department' => 'Khoa Tiêu hóa'],
                            ['id' => 'BS010', 'name' => 'Đỗ Thị Hải Yến', 'gender' => 'Nữ', 'department' => 'Khoa Ung bướu'],
                            ['id' => 'BS011', 'name' => 'Nguyễn Văn Thành', 'gender' => 'Nam', 'department' => 'Khoa Nội khoa'],
                            ['id' => 'BS012', 'name' => 'Trần Thúy Hạnh', 'gender' => 'Nữ', 'department' => 'Khoa Ngoại khoa'],
                            ['id' => 'BS013', 'name' => 'Hoàng Thế Nam', 'gender' => 'Nam', 'department' => 'Khoa Sản'],
                            ['id' => 'BS014', 'name' => 'Ngô Văn Tâm', 'gender' => 'Nam', 'department' => 'Khoa Sản'],
                            ['id' => 'BS015', 'name' => 'Bùi Thị Kim Hạnh', 'gender' => 'Nữ', 'department' => 'Khoa Nhi'],
                            ['id' => 'BS016', 'name' => 'Vương Thị Thuý Nhi', 'gender' => 'Nữ', 'department' => 'Khoa Nhi'],
                            ['id' => 'BS017', 'name' => 'Đinh Văn Toàn', 'gender' => 'Nam', 'department' => 'Khoa Mắt'],
                            ['id' => 'BS018', 'name' => 'Nguyễn Thị Thu Hằng', 'gender' => 'Nữ', 'department' => 'Khoa Mắt'],
                            ['id' => 'BS019', 'name' => 'Lê Văn Bảo', 'gender' => 'Nam', 'department' => 'Khoa Ung bướu'],
                            ['id' => 'BS020', 'name' => 'Trịnh Thị Thanh Tâm', 'gender' => 'Nữ', 'department' => 'Khoa Nhi'],
                            ['id' => 'BS021', 'name' => 'Phan Minh Đức', 'gender' => 'Nam', 'department' => 'Khoa Ung bướu'],
                        ];
                    @endphp

                    @foreach ($doctors as $doctor)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <img src="https://randomuser.me/api/portraits/{{ $doctor['gender'] == 'Nam' ? 'men' : 'women' }}/{{ rand(10,99) }}.jpg" 
                                     alt="avatar" class="w-10 h-10 rounded-full object-cover border">
                            </td>
                            <td class="px-4 py-3 font-medium">{{ $doctor['id'] }}</td>
                            <td class="px-4 py-3">{{ $doctor['name'] }}</td>
                            <td class="px-4 py-3">{{ $doctor['gender'] }}</td>
                            <td class="px-4 py-3">{{ $doctor['department'] }}</td>
                            <td class="px-4 py-3">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-sm transition">Xem</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

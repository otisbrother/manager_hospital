<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Khoa - Bệnh nhân</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="min-h-screen text-gray-800 font-sans bg-gradient-to-br from-purple-500 via-pink-200 to-white">

    <div class="max-w-6xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
            🏥 Danh sách các khoa trong bệnh viện
        </h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow-md overflow-hidden">
                <thead class="bg-blue-600 text-white text-left">
                    <tr>
                        <th class="py-3 px-4">Mã khoa</th>
                        <th class="py-3 px-4">Tên khoa</th>
                        <th class="py-3 px-4">Vị trí</th>
                        <th class="py-3 px-4 text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @php
                        $departments = [
                            ['id' => 'KH001', 'name' => 'Khoa Nội khoa', 'location' => 'Tầng 2, Nhà A'],
                            ['id' => 'KH002', 'name' => 'Khoa Ngoại khoa', 'location' => 'Tầng 3, Nhà B'],
                            ['id' => 'KH003', 'name' => 'Khoa Tai mũi họng', 'location' => 'Tầng 4, Nhà C'],
                            ['id' => 'KH004', 'name' => 'Khoa Răng Hàm Mặt', 'location' => 'Tầng 2, Nhà B'],
                            ['id' => 'KH005', 'name' => 'Khoa Mắt', 'location' => 'Tầng 2, Nhà D'],
                            ['id' => 'KH006', 'name' => 'Khoa Sản', 'location' => 'Tầng 3, Nhà A'],
                            ['id' => 'KH007', 'name' => 'Khoa Nhi', 'location' => 'Tầng 4, Nhà B'],
                            ['id' => 'KH008', 'name' => 'Khoa Tim mạch', 'location' => 'Tầng 5, Nhà C'],
                            ['id' => 'KH009', 'name' => 'Khoa Tiêu hóa', 'location' => 'Tầng 6, Nhà A'],
                            ['id' => 'KH010', 'name' => 'Khoa Ung bướu', 'location' => 'Tầng 7, Nhà D'],
                        ];
                    @endphp

                    @foreach ($departments as $dept)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $dept['id'] }}</td>
                            <td class="py-3 px-4">{{ $dept['name'] }}</td>
                            <td class="py-3 px-4">{{ $dept['location'] }}</td>
                            <td class="py-3 px-4 text-center">
                             <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg mr-2 transition-all">
                                 <i class="ph ph-eye"></i> Xem
                             </button>

                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('patient.home') }}" class="inline-block mt-4 text-blue-600 hover:underline">
                ← Quay về trang chủ
            </a>
        </div>
    </div>

</body>
</html>

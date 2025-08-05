@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                📋 Chi tiết hồ sơ BHYT
            </h2>
            <a href="{{ route('admin.insurances.index') }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                ← Quay lại
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                
                <!-- Thông tin bệnh nhân -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin bệnh nhân</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mã bệnh nhân</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->patient->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Họ và tên</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->patient->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->patient->phone ?? 'Chưa cập nhật' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->patient->email ?? 'Chưa cập nhật' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Thông tin hồ sơ BHYT -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin hồ sơ BHYT</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mã BHYT</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->insurance_id ?? 'Không có' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mức hỗ trợ</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($application->support_level == '80') bg-blue-100 text-blue-800
                                @elseif($application->support_level == '95') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ $application->support_level_text }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Trạng thái</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($application->status == 'approved') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $application->status_text }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ngày đăng ký</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ảnh chứng minh -->
                @if($application->proof_images && count($application->proof_images) > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ảnh chứng minh</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($application->proof_images as $image)
                        <div class="border rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($image) }}" 
                                 alt="Ảnh chứng minh" 
                                 class="w-full h-48 object-cover cursor-pointer"
                                 onclick="openImageModal('{{ Storage::url($image) }}')"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xMDAgNzBDMTE2LjU2OSA3MCAxMzAgODMuNDMxIDMwIDEwMEMxMzAgMTE2LjU2OSAxMTYuNTY5IDEzMCAxMDAgMTMwQzgzLjQzMSAxMzAgNzAgMTE2LjU2OSA3MCAxMEM3MCA4My40MzEgODMuNDMxIDcwIDEwMCA3MFoiIGZpbGw9IiM5Q0EzQUYiLz4KPHRleHQgeD0iMTAwIiB5PSIxNjAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzY3NzQ4MCIgdGV4dC1hbmNob3I9Im1pZGRsZSI+0JDQvdCw0YHRgtGA0L7QudC60Lg8L3RleHQ+Cjwvc3ZnPgo='; this.alt='Không thể tải ảnh';">
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ảnh chứng minh</h3>
                    <div class="p-4 bg-gray-100 rounded-lg">
                        <p class="text-gray-600">Không có ảnh chứng minh nào được đính kèm.</p>
                    </div>
                </div>
                @endif

                <!-- Thông tin duyệt -->
                @if($application->status != 'pending')
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin duyệt</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Người duyệt</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->approvedBy->name ?? 'Không xác định' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Thời gian duyệt</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->approved_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($application->admin_notes)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Ghi chú</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $application->admin_notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Nút duyệt/từ chối (chỉ hiển thị khi chờ duyệt) -->
                @if($application->status == 'pending')
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thao tác duyệt</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Form duyệt -->
                        <div class="border rounded-lg p-4 bg-green-50">
                            <h4 class="font-medium text-green-900 mb-3">✅ Duyệt hồ sơ</h4>
                            <form action="{{ route('admin.insurances.application.approve', $application->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="approve_notes" class="block text-sm font-medium text-gray-700">Ghi chú (không bắt buộc)</label>
                                    <textarea id="approve_notes" name="admin_notes" rows="3" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Ghi chú khi duyệt hồ sơ..."></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    Duyệt hồ sơ
                                </button>
                            </form>
                        </div>

                        <!-- Form từ chối -->
                        <div class="border rounded-lg p-4 bg-red-50">
                            <h4 class="font-medium text-red-900 mb-3">❌ Từ chối hồ sơ</h4>
                            <form action="{{ route('admin.insurances.application.reject', $application->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="reject_notes" class="block text-sm font-medium text-gray-700">Lý do từ chối *</label>
                                    <textarea id="reject_notes" name="admin_notes" rows="3" required
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                              placeholder="Nhập lý do từ chối hồ sơ..."></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                    Từ chối hồ sơ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal xem ảnh -->
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
    <div class="max-w-4xl max-h-full p-4">
        <div class="relative">
            <button onclick="closeImageModal()" 
                    class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="modal-image" src="" alt="Ảnh chứng minh" class="max-w-full max-h-full object-contain">
        </div>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        document.getElementById('modal-image').src = imageSrc;
        document.getElementById('image-modal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('image-modal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('image-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
</script>
@endsection 
@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                🩺 Quản lý Bảo Hiểm Y Tế
            </h2>
        </div>
        
        <!-- Thống kê -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $applications->where('status', 'pending')->count() }}</div>
                <div class="text-sm text-blue-800">⏳ Hồ sơ chờ duyệt</div>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $applications->where('status', 'approved')->count() }}</div>
                <div class="text-sm text-green-800">✅ Hồ sơ đã duyệt</div>
            </div>
            <div class="bg-red-100 p-4 rounded-lg">
                <div class="text-2xl font-bold text-red-600">{{ $applications->where('status', 'rejected')->count() }}</div>
                <div class="text-sm text-red-800">❌ Hồ sơ bị từ chối</div>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg">
                <div class="text-2xl font-bold text-gray-600">{{ $insurances->count() }}</div>
                <div class="text-sm text-gray-800">📊 Tổng thẻ BHYT</div>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="showTab('applications')" 
                            class="tab-btn py-2 px-1 border-b-2 font-medium text-sm active-tab"
                            id="applications-tab">
                        📋 Hồ sơ đăng ký BHYT
                    </button>
                    <button onclick="showTab('insurances')" 
                            class="tab-btn py-2 px-1 border-b-2 font-medium text-sm"
                            id="insurances-tab">
                        🩺 Danh sách thẻ BHYT
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
            <!-- Hồ sơ đăng ký BHYT Tab -->
            <div id="applications-content" class="tab-content">
                <div class="p-6">
                    <!-- Bộ lọc -->
                    <div class="mb-6">
                        <div class="flex space-x-4">
                            <button onclick="filterApplications('all')" class="filter-btn px-4 py-2 rounded-md bg-blue-600 text-white">
                                Tất cả
                            </button>
                            <button onclick="filterApplications('pending')" class="filter-btn px-4 py-2 rounded-md bg-gray-300 text-gray-700">
                                ⏳ Chờ duyệt
                            </button>
                            <button onclick="filterApplications('approved')" class="filter-btn px-4 py-2 rounded-md bg-gray-300 text-gray-700">
                                ✅ Đã duyệt
                            </button>
                            <button onclick="filterApplications('rejected')" class="filter-btn px-4 py-2 rounded-md bg-gray-300 text-gray-700">
                                ❌ Bị từ chối
                            </button>
                        </div>
                    </div>

                    <!-- Bảng hồ sơ đăng ký -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bệnh nhân
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mã BHYT
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mức hỗ trợ
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Trạng thái
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ngày đăng ký
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($applications as $application)
                                <tr class="application-row" data-status="{{ $application->status }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $application->patient->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $application->patient->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $application->insurance_id ?? 'Không có' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($application->support_level == '80') bg-blue-100 text-blue-800
                                            @elseif($application->support_level == '95') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ $application->support_level }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($application->status == 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $application->status_text }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $application->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.insurances.application.show', $application->id) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($applications->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Không có hồ sơ nào</h3>
                        <p class="mt-1 text-sm text-gray-500">Chưa có hồ sơ đăng ký BHYT nào trong hệ thống.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Danh sách thẻ BHYT Tab -->
            <div id="insurances-content" class="tab-content" style="display: none;">
                <div class="p-6">
                    <table class="w-full table-auto border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">Mã BHYT</th>
                                <th class="border px-4 py-2 text-left">Ngày đăng ký</th>
                                <th class="border px-4 py-2 text-left">Ngày hết hạn</th>
                                <th class="border px-4 py-2 text-left">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($insurances as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $item->id }}</td>
                                    <td class="border px-4 py-2">{{ $item->register_date }}</td>
                                    <td class="border px-4 py-2">{{ $item->expire_date }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.insurances.show', $item->id) }}" class="text-blue-600 hover:underline">Xem</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">Không có dữ liệu thẻ BHYT nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .active-tab {
        border-color: #3b82f6;
        color: #3b82f6;
    }
    .tab-btn {
        border-color: transparent;
        color: #6b7280;
    }
    .tab-btn:hover {
        border-color: #d1d5db;
        color: #374151;
    }
</style>

<script>
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active-tab');
            btn.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        document.getElementById(tabName + '-content').style.display = 'block';
        
        // Add active class to selected tab
        document.getElementById(tabName + '-tab').classList.add('active-tab');
        document.getElementById(tabName + '-tab').classList.remove('border-transparent', 'text-gray-500');
    }

    function filterApplications(status) {
        // Update button styles
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-300', 'text-gray-700');
        });
        
        event.target.classList.remove('bg-gray-300', 'text-gray-700');
        event.target.classList.add('bg-blue-600', 'text-white');
        
        // Filter rows
        const rows = document.querySelectorAll('.application-row');
        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">👁️ Chi tiết sổ khám bệnh</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Mã sổ khám (MASKB)</label>
                <div class="mt-1 text-gray-900">{{ $record->id }}</div>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">STT</label>
                <div class="mt-1 text-gray-900">{{ $record->order }}</div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.medical-records.edit', [$record->id, $record->order]) }}"
                   class="text-indigo-600 hover:underline font-medium">Sửa</a>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">✏️ Chỉnh sửa sổ khám bệnh</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('admin.medical-records.update', [$record->id, $record->order]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Mã sổ khám (MASKB)</label>
                    <input type="text" value="{{ $record->id }}" disabled class="block w-full bg-gray-100 border-gray-300 rounded shadow-sm">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium">STT</label>
                    <input type="number" name="order" value="{{ old('order', $record->order) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Chỉnh sửa chi tiết đơn thuốc</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('admin.detail-prescriptions.update', [$detail->prescription_id, $detail->medicine_id]) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Mã đơn thuốc</label>
                    <input type="text" value="{{ $detail->prescription_id }}" disabled
                           class="block w-full bg-gray-100 rounded border-gray-300 shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Mã thuốc</label>
                    <input type="text" value="{{ $detail->medicine_id }}" disabled
                           class="block w-full bg-gray-100 rounded border-gray-300 shadow-sm">
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-gray-700">Số lượng</label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity', $detail->quantity) }}"
                           class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded shadow">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

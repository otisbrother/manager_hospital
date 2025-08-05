<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Thêm thuốc</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('admin.medicines.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Mã thuốc</label>
                    <input type="text" name="id" value="{{ old('id') }}" required maxlength="10"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Tên thuốc</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Công dụng</label>
                    <textarea name="usage" rows="2"
                              class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('usage') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Đơn vị tính</label>
                    <input type="text" name="unit" value="{{ old('unit') }}"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Hạn sử dụng</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium">Giá tiền</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                           class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded shadow">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

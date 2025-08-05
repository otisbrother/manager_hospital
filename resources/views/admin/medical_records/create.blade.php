<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">➕ Thêm sổ khám bệnh</h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <form action="{{ route('admin.medical-records.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Mã sổ khám (MASKB)</label>
                    <input type="text" name="id" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium">STT</label>
                    <input type="number" name="order" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded shadow">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-app-layout>

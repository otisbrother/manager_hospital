<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            ✏️ Chỉnh sửa hóa đơn
        </h2>
    </x-slot>

    <div class="py-6 px-6 bg-white rounded shadow">
        <form action="{{ route('admin.bills.update', $bill->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.bills._form', ['bill' => $bill])
        </form>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            ✏️ Cập nhật Thân nhân
        </h2>
    </x-slot>
    @section('content')
    <div class="py-6 px-6 bg-white rounded shadow w-full">
        @include('admin.relatives._form', ['relative' => $relative])
    </div>
    @endsection
</x-app-layout>

<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold">✏️ Sửa loại bệnh nhân</h2></x-slot>
    @section('content')
    <div class="py-6 max-w-xl mx-auto bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('admin.type_patients.update', $type->id) }}">
            @method('PUT')
            @include('admin.type_patients._form')
        </form>
    </div>
    @endsection
</x-app-layout>
